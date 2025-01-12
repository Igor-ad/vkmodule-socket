<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use PHPUnit\Framework\TestCase;

class TcpConnectorInit extends TestCase
{
    protected Connector $connectorObject;

    protected function setUp(): void
    {
        $command = __DIR__ . "/../../../console/server.php >/dev/null 2>&1 &";
        exec($command);
        usleep(300 * 1000);

        $this->connectorObject = new TcpConnector('localhost');
    }
}
