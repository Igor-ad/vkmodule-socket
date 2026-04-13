<?php

declare(strict_types=1);

namespace Tests;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;
use Tests\Support\TestTcpServer;

class LocalSocketServerInit extends TestCase
{
    protected int $port;

    protected ConfigurationProvider $testConfiguration;

    public function setUp(): void
    {
        parent::setUp();

        $this->testConfiguration = ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath());
        $this->port = (int) $this->testConfiguration->get('port');
        $this->ensureTestTcpServerIsListening();
    }

    /**
     * Ensures the loopback TCP test server is accepting (see {@see Files::TestTcpServer}).
     * Default canned response {@see TestTcpServer} matches simple unit scenarios (e.g. {@code 01}).
     */
    protected function ensureTestTcpServerIsListening(string $outgoingHex = '01'): void
    {
        $timeout = (string) $this->testConfiguration->get('timeout');
        $binary = $this->hexStringToBinary($outgoingHex);
        $encodeOutgoingStream = base64_encode($binary);

        try {
            TestTcpServer::ensure($this->port, $timeout, $encodeOutgoingStream, false);
        } catch (\RuntimeException $exception) {
            $this->markTestSkipped($exception->getMessage());
        }
    }

    private function hexStringToBinary(string $outgoingStream): string
    {
        if (strlen($outgoingStream) % 2 !== 0) {
            throw new \InvalidArgumentException('The length of the hexadecimal string must be even.');
        }

        $outgoingStreamData = str_split($outgoingStream, 2);

        return implode('', array_map(static fn (string $hexPair): string => chr(hexdec($hexPair)), $outgoingStreamData));
    }
}
