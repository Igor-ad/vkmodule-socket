<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;

class TcpConnectorInit extends TestCase
{
    protected Connector $connectorObject;

    protected function setUp(): void
    {
        $command = Files::TcpServer->getPath() . " >/dev/null 2>&1 &";
        exec($command);
        usleep(400 * 1000);

        $this->connectorObject = new TcpConnector('localhost', 9761);
    }
}
