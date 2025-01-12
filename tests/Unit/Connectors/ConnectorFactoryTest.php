<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\ConnectorFactory;
use Autodoctor\ModuleSocket\Connectors\HttpConnector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ConnectorFactory::class)]
#[CoversClass(TcpConnector::class)]
#[CoversClass(HttpConnector::class)]
class ConnectorFactoryTest extends TcpConnectorInit
{
    public function testConnectInit(): void
    {
        $this->assertInstanceOf(TcpConnector::class, $this->connectorObject);

        $this->connectorObject = ConnectorFactory::connectInit('google.com', 80, 'HTTP');

        $this->assertInstanceOf(HttpConnector::class, $this->connectorObject);
    }
}
