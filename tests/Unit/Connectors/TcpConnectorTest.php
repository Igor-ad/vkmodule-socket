<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TcpConnector::class)]
class TcpConnectorTest extends TcpConnectorInit
{
    public function testSetConnector(): void
    {
        $this->assertInstanceOf(Connector::class, $this->connectorObject);

        $this->expectException(ConnectorException::class);
        $this->connectorObject = new TcpConnector('localhost', 9762);
    }
}
