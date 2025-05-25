<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors\Clients;

use Autodoctor\ModuleSocket\Connectors\Clients\TcpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Connectors\TcpConnectorInit;

#[CoversClass(TcpConnector::class)]
class TcpConnectorTest extends TcpConnectorInit
{
    public function testSetConnector(): void
    {
        $invalidPort = 9700;
        $this->assertInstanceOf(Connector::class, $this->connectorObject);

        $this->expectException(ConnectorException::class);
        @$this->connectorObject = new TcpConnector('localhost', $invalidPort);
    }
}
