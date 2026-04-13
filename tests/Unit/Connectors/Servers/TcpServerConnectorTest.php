<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors\Servers;

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TcpServerConnector::class)]
class TcpServerConnectorTest extends TestCase
{

    public function testSetConnector(): void
    {
        $tcpServerConnector = new TcpServerConnector('localhost', 9760, 1);
        $connector = $tcpServerConnector->getConnector();

        $this->assertIsResource($connector);
    }

    public function testSetConnectorException(): void
    {
        $this->expectException(ConnectorException::class);
        @ new TcpServerConnector('google.com', 22);
    }

    public function testListenOnceReturnsFalseWhenAcceptTimesOut(): void
    {
        $tcpServerConnector = new TcpServerConnector('127.0.0.1', 0, 1);
        $server = $tcpServerConnector->getConnector();

        $this->assertFalse($tcpServerConnector->listenOnce($server, 0.05));
    }

    public function testListenOnceRejectsNonResourceServer(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid server socket');

        $tcpServerConnector = new TcpServerConnector('127.0.0.1', 0, 1);
        $tcpServerConnector->listenOnce(false);
    }

    public function testListenOnceAcceptsOneInboundConnection(): void
    {
        $clientScript = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'Support' . DIRECTORY_SEPARATOR . 'TcpOneShotClient.php';
        if (!is_file($clientScript)) {
            self::markTestSkipped('TcpOneShotClient.php not found at ' . $clientScript);
        }

        $tcpServerConnector = new TcpServerConnector('127.0.0.1', 0, 2);
        $server = $tcpServerConnector->getConnector();
        $name = stream_socket_get_name($server, false);
        if ($name === false || !preg_match('/:(\d+)$/', $name, $matches)) {
            self::markTestSkipped('Could not resolve ephemeral port from server socket.');
        }

        $port = (int) $matches[1];
        $descriptorSpec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $cmd = [PHP_BINARY, $clientScript, (string) $port, '01'];
        $process = proc_open($cmd, $descriptorSpec, $pipes, null, null, ['bypass_shell' => true]);
        if (!is_resource($process)) {
            self::markTestSkipped('proc_open is not available or failed.');
        }
        fclose($pipes[0]);

        $accepted = $tcpServerConnector->listenOnce($server, 5.0, null);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);

        $this->assertTrue($accepted, 'listenOnce should accept the client; client stderr: ' . $stderr);
    }
}
