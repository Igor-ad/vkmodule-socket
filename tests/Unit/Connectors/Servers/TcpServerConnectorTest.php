<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors\Servers;

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;
use PHPUnit\Framework\TestCase;

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
}
