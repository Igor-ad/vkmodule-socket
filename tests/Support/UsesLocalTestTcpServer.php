<?php

declare(strict_types=1);

namespace Tests\Support;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;

/**
 * Opt-in TCP test listener for a single test method (unlike {@see \Tests\LocalSocketServerInit}, which runs in setUp()).
 *
 * @mixin TestCase
 */
trait UsesLocalTestTcpServer
{
    protected function ensureLocalTestTcpServerListening(string $outgoingHex = '01'): int
    {
        $configuration = ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath());
        $port = (int) $configuration->get('port');
        $timeout = (string) $configuration->get('timeout');
        $binary = self::hexStreamToBinary($outgoingHex);

        try {
            TestTcpServer::ensure($port, $timeout, base64_encode($binary), false);
        } catch (\RuntimeException $exception) {
            $this->markTestSkipped($exception->getMessage());
        }

        return $port;
    }

    private static function hexStreamToBinary(string $outgoingStream): string
    {
        if (strlen($outgoingStream) % 2 !== 0) {
            throw new \InvalidArgumentException('The length of the hexadecimal string must be even.');
        }

        $pairs = str_split($outgoingStream, 2);

        return implode('', array_map(static fn (string $hexPair): string => chr(hexdec($hexPair)), $pairs));
    }
}
