<?php

declare(strict_types=1);

namespace Tests\Support;

use Autodoctor\ModuleSocket\Enums\Files;

/**
 * Manages the background PHP {@see Files::TestTcpServer} process so Feature tests can switch
 * canned responses per case (same port, different payload).
 *
 * On normal PHPUnit exit, a shutdown handler stops the child (SIGTERM, then SIGKILL / {@see posix_kill} when available)
 * and runs {@see tryForceReleasePort} so the test port does not stay in LISTEN.
 * If you stop the suite with SIGKILL, remove the orphan process yourself (e.g. {@code kill <pid>}).
 */
final class TestTcpServer
{
    public const BIND_HOST = '127.0.0.1';

    private const WAIT_PORT_FREE_SECONDS = 15.0;

    private const WAIT_PORT_READY_SECONDS = 25.0;

    /** @var resource|null */
    private static $process = null;

    private static ?int $childPid = null;

    private static ?int $trackedPort = null;

    private static ?string $lastPayloadBase64 = null;

    private static bool $shutdownHandlerRegistered = false;

    /**
     * Keeps the test TCP server running with the given base64-encoded outbound payload.
     * Restarts the managed process when the payload changes, the port is not accepting, or the child exited.
     *
     * @param bool $reuseExisting When true, skip stop/spawn if the same payload is already served and the child is
     *                             healthy. Unit tests pass false so a full run after Feature cannot reuse a wedged
     *                             listener that still accepts probes but times out real clients.
     *
     * @throws \RuntimeException if the port never becomes ready after spawn
     */
    public static function ensure(int $port, string $timeoutArg, string $payloadBase64, bool $reuseExisting = true): void
    {
        if (
            $reuseExisting
            && self::$lastPayloadBase64 === $payloadBase64
            && self::isPortAccepting($port)
            && self::isManagedProcessRunning()
        ) {
            return;
        }

        self::stopManagedProcess();
        self::tryForceReleasePort($port);
        self::waitUntilPortFree($port, self::WAIT_PORT_FREE_SECONDS);
        self::spawnProcess($port, $timeoutArg, $payloadBase64);
        self::$lastPayloadBase64 = $payloadBase64;
        self::waitUntilPortAccepts($port, self::WAIT_PORT_READY_SECONDS);
    }

    public static function stopManagedProcess(): void
    {
        if (self::$process !== null && is_resource(self::$process)) {
            $sigterm = defined('SIGTERM') ? (int) SIGTERM : 15;
            $sigkill = defined('SIGKILL') ? (int) SIGKILL : 9;
            @proc_terminate(self::$process, $sigterm);
            self::waitChildNotRunning(40);

            if (self::isProcessResourceRunning(self::$process)) {
                @proc_terminate(self::$process, $sigkill);
                self::waitChildNotRunning(40);
            }

            $pid = self::$childPid;
            if ($pid !== null && $pid > 0 && function_exists('posix_kill')) {
                @posix_kill($pid, $sigkill);
                usleep(100_000);
            }

            proc_close(self::$process);
        }

        self::$process = null;
        self::$childPid = null;
        self::$lastPayloadBase64 = null;

        if (self::$trackedPort !== null) {
            self::tryForceReleasePort(self::$trackedPort);
            self::$trackedPort = null;
        }
    }

    /**
     * @param resource $process
     */
    private static function isProcessResourceRunning($process): bool
    {
        if (!is_resource($process)) {
            return false;
        }
        $status = @proc_get_status($process);

        return $status !== false && ($status['running'] ?? false);
    }

    private static function waitChildNotRunning(int $maxIterations): void
    {
        if (self::$process === null || !is_resource(self::$process)) {
            return;
        }
        for ($i = 0; $i < $maxIterations; ++$i) {
            if (!self::isProcessResourceRunning(self::$process)) {
                return;
            }
            usleep(50_000);
        }
    }

    private static function isManagedProcessRunning(): bool
    {
        if (self::$process === null || !is_resource(self::$process)) {
            return false;
        }
        $status = @proc_get_status(self::$process);

        return $status !== false && ($status['running'] ?? false);
    }

    public static function isPortAccepting(int $port): bool
    {
        $resource = @fsockopen(self::BIND_HOST, $port, $errno, $errstr, 1.0);
        if ($resource === false) {
            return false;
        }
        fclose($resource);

        return true;
    }

    /**
     * Best-effort: kill any listener on the port (orphan test_server from a killed PHPUnit run).
     * Linux only; no-op on Windows.
     */
    public static function tryForceReleasePort(int $port): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return;
        }
        $port = max(1, min(65535, $port));
        exec(sprintf('fuser -k %d/tcp 2>/dev/null || true', $port));
        usleep(200_000);
    }

    private static function waitUntilPortFree(int $port, float $maxSeconds): void
    {
        $deadline = microtime(true) + $maxSeconds;
        while (microtime(true) < $deadline) {
            if (!self::isPortAccepting($port)) {
                return;
            }
            if (microtime(true) > $deadline - 5.0) {
                self::tryForceReleasePort($port);
            }
            usleep(100_000);
        }

        self::tryForceReleasePort($port);
        usleep(300_000);

        if (self::isPortAccepting($port)) {
            throw new \RuntimeException(sprintf(
                'Port %d is still in use after %.1fs (orphan listener). Stop it, then retry.',
                $port,
                $maxSeconds,
            ));
        }
    }

    private static function waitUntilPortAccepts(int $port, float $maxSeconds): void
    {
        $deadline = microtime(true) + $maxSeconds;
        while (microtime(true) < $deadline) {
            if (self::isPortAccepting($port) && self::isManagedProcessRunning()) {
                return;
            }
            if (!self::isManagedProcessRunning() && self::$process !== null) {
                self::stopManagedProcess();
                throw new \RuntimeException('Test TCP server process exited before the port became ready.');
            }
            usleep(50_000);
        }

        throw new \RuntimeException(sprintf(
            'Test TCP server on %s:%d did not become ready within %.1fs.',
            self::BIND_HOST,
            $port,
            $maxSeconds,
        ));
    }

    private static function spawnProcess(int $port, string $timeoutArg, string $payloadBase64): void
    {
        $script = Files::TestTcpServer->getPath();
        if (!is_file($script)) {
            throw new \RuntimeException('Test TCP server script not found: ' . $script);
        }

        $portArg = (string) $port;
        $php = PHP_BINARY;
        $projectRoot = dirname($script, 2);
        $nullDevice = PHP_OS_FAMILY === 'Windows' ? 'NUL' : '/dev/null';
        $descriptorSpec = [
            0 => ['pipe', 'r'],
            1 => ['file', $nullDevice, 'a'],
            2 => ['file', $nullDevice, 'a'],
        ];
        $command = [$php, $script, $portArg, $timeoutArg, $payloadBase64];
        $process = proc_open($command, $descriptorSpec, $pipes, $projectRoot, null, ['bypass_shell' => true]);
        if (!is_resource($process)) {
            throw new \RuntimeException('Failed to spawn test TCP server (proc_open).');
        }
        if (isset($pipes[0]) && is_resource($pipes[0])) {
            fclose($pipes[0]);
        }
        self::$process = $process;
        self::$trackedPort = $port;
        self::captureChildPid();
        self::registerShutdownHandlerOnce();
    }

    private static function captureChildPid(): void
    {
        self::$childPid = null;
        if (self::$process === null || !is_resource(self::$process)) {
            return;
        }
        for ($i = 0; $i < 50; ++$i) {
            $status = @proc_get_status(self::$process);
            if ($status !== false && ($status['pid'] ?? 0) > 0) {
                self::$childPid = (int) $status['pid'];

                return;
            }
            usleep(20_000);
        }
    }

    private static function registerShutdownHandlerOnce(): void
    {
        if (self::$shutdownHandlerRegistered) {
            return;
        }
        self::$shutdownHandlerRegistered = true;
        register_shutdown_function(static function (): void {
            self::stopManagedProcess();
        });
    }
}
