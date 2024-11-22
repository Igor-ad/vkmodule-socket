<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors\Servers;

use Autodoctor\ModuleSocket\Connectors\AbstractConnector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;

class TcpServerConnector extends AbstractConnector
{
    /**
     * @throws ConnectorException
     */
    protected function setConnector(string $host, int $port = 9761, float $timeout = null): void
    {
        $this->connector = stream_socket_server(
            "tcp://$host:$port", $errorCode, $errorMessage
        );

        if ($this->connector === false) {
            throw new ConnectorException(
                'Cannot initialise TCP Server Socket Connector: ' . $errorMessage
                . ' Error Code: ' . $errorCode
            );
        }
    }
}
