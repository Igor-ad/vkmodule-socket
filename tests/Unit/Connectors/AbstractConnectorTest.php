<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\AbstractConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractConnector::class)]
#[CoversClass(TcpConnector::class)]
class AbstractConnectorTest extends TcpConnectorInit
{
    public function test__construct(): void
    {
        $this->assertInstanceOf(Connector::class, $this->connectorObject);
    }

    public function testGetConnector(): void
    {
        $this->assertIsResource($this->connectorObject->getConnector());
    }
}
