<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\Clients\TcpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;

class TcpConnectorInit extends TestCase
{
    protected Connector $connectorObject;

    protected function setUp(): void
    {
        $port = 9761;
        $command = Files::TcpServer->getPath() . " '$port' >/dev/null 2>&1 &";
        exec($command);
        usleep(300 * 1000);

        @$this->connectorObject = new TcpConnector('localhost', 9761, 5);
    }
}
