<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors\Clients;

use Autodoctor\ModuleSocket\Connectors\AbstractConnector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;

class TcpConnector extends AbstractConnector
{
    /**
     * @throws ConnectorException
     */
    protected function setConnector(string $host, int $port = 9761, ?float $timeout = null): void
    {
        $this->connector = stream_socket_client(
            "tcp://$host:$port",
            $errorCode,
            $errorMessage,
            $this->timeout,
        );

        if ($this->connector === false) {
            throw new ConnectorException(
                'Cannot initialise TCP Socket Connector: '
                . $errorMessage
                . ' Error Code: '
                . $errorCode
            );
        }
    }
}
