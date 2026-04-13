<?php

declare(strict_types=1);

namespace Tests\Feature;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;
use Tests\Support\TestTcpServer;

class ProxyLocalSocketServerInit extends TestCase
{
    public function proxyServerInit(string $outgoingStream): void
    {
        $configuration = ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath());
        $port = (int) $configuration->get('port');
        $timeout = (string) $configuration->get('timeout');
        $encodeOutgoingStream = base64_encode($outgoingStream);

        try {
            TestTcpServer::ensure($port, $timeout, $encodeOutgoingStream);
        } catch (\RuntimeException $exception) {
            $this->markTestSkipped($exception->getMessage());
        }
    }
}
