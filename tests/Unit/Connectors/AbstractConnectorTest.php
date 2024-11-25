<?php declare(strict_types=1);

namespace Connectors;

use Autodoctor\ModuleSocket\Connectors\AbstractConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConnector::class)]
#[CoversClass(TcpConnector::class)]
class AbstractConnectorTest extends TestCase
{
    protected Connector $connectorObject;

    protected function setUp(): void
    {
        $command = "./console/server.php >/dev/null 2>&1 &";
        exec($command);

        $this->connectorObject = new TcpConnector('localhost');
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Connector::class, $this->connectorObject);
    }

    public function testGetConnector(): void
    {
        $this->assertIsResource($this->connectorObject->getConnector());
    }

    protected function tearDown(): void
    {
    }
}
