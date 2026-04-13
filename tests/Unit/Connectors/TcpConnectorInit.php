<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\Clients\TcpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Tests\LocalSocketServerInit;

class TcpConnectorInit extends LocalSocketServerInit
{
    protected Connector $connectorObject;

    public function setUp(): void
    {
        parent::setUp();
        $host = $this->testConfiguration->get('host');
        $port = $this->testConfiguration->get('port');
        $timeout = $this->testConfiguration->get('timeout');

        @$this->connectorObject = new TcpConnector($host, $port, $timeout);
    }
}
