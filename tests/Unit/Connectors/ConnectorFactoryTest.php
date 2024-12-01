<?php declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\ConnectorFactory;
use Autodoctor\ModuleSocket\Connectors\HttpConnector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConnectorFactory::class)]
#[CoversClass(TcpConnector::class)]
#[CoversClass(HttpConnector::class)]
class ConnectorFactoryTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $command = __DIR__ . "/../../../console/server.php >/dev/null 2>&1 &";
        exec($command);
        sleep(1);
    }

    public function testConnectInit(): void
    {
        $connector = ConnectorFactory::connectInit('localhost');

        $this->assertInstanceOf(TcpConnector::class, $connector);

        $connector = ConnectorFactory::connectInit('google.com', 80, 'HTTP');

        $this->assertInstanceOf(HttpConnector::class, $connector);
    }
}
