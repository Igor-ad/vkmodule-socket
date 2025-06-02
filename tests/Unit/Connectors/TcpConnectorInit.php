<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Configurator;
use Autodoctor\ModuleSocket\Connectors\Clients\TcpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Enums\Files;
use Tests\LocalSocketServerInit;

class TcpConnectorInit extends LocalSocketServerInit
{
    protected Connector $connectorObject;

    public function setUp(): void
    {
        parent::setUp();
        $host = Configurator::instance(Files::TestConfigFile->getPath())->get('host');
        $port = Configurator::instance(Files::TestConfigFile->getPath())->get('port');
        $timeout = Configurator::instance(Files::TestConfigFile->getPath())->get('timeout');

        @$this->connectorObject = new TcpConnector($host, $port, $timeout);
    }
}
