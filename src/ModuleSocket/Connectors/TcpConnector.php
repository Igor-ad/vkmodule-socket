<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use Autodoctor\ModuleSocket\Exceptions\ConnectorException;
use Autodoctor\ModuleSocket\ValueObjects\Module;

class TcpConnector extends AbstractConnector
{
    protected const CONNECT_TIMEOUT = 30;

    protected $connector;

    /**
     * @throws ConnectorException
     */
    public function __construct(Module $module, ?float $timeout = null)
    {
        $timeout = $timeout ?? $this->getTimeout();
        $this->connector = fsockopen($module->host, $module->port, $error_code, $error_message, $timeout);

        if ($this->connector === false) {
            throw new ConnectorException(
                'Cannot initialise TCP Socket Connector: ' . $error_message
                . ' Error Code: ' . $error_code
            );
        }
    }
}
