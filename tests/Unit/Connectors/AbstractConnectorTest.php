<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\AbstractConnector;
use Autodoctor\ModuleSocket\Connectors\Clients\TcpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractConnector::class)]
#[CoversClass(TcpConnector::class)]
class AbstractConnectorTest extends TcpConnectorInit
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(Connector::class, $this->connectorObject);
    }

    public function testGetConnector(): void
    {
        $this->assertIsResource($this->connectorObject->getConnector());
    }
}
