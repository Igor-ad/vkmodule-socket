<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors\Servers;

use Autodoctor\ModuleSocket\Connectors\AbstractConnector;
use Autodoctor\ModuleSocket\Exceptions\ConnectorException;

class TcpServerConnector extends AbstractConnector
{
    /**
     * @throws ConnectorException
     */
    protected function setConnector(string $host, int $port = 9761, ?float $timeout = null): void
    {
        $this->connector = stream_socket_server(
            "tcp://$host:$port",
            $errorCode,
            $errorMessage,
        );

        if ($this->connector === false) {
            throw new ConnectorException(
                'Cannot initialise TCP Server Socket Connector: '
                . $errorMessage
                . '. Error Code: '
                . $errorCode
            );
        }
    }

    public function listenMirrored($server, ?float $timeout = 5, ?string $outputStream = null): void
    {
        while (true) {
            $listener = stream_socket_accept($server, $timeout ??= $this->timeout);
            $inputStream = fread($listener, 32);
            $outputStream ??= $inputStream;
            fwrite($listener, $outputStream);

            stream_socket_shutdown($listener, STREAM_SHUT_RDWR);
            fclose($listener);
        }
    }

    public function listenOnce($server, ?float $timeout = 5, ?string $outputStream = null): void
    {
        if (!is_resource($server)) {
            throw new \InvalidArgumentException('Invalid server socket.' . PHP_EOL);
        }

        $listener = stream_socket_accept($server, $timeout);
        if ($listener === false) {
            throw new \RuntimeException('Failed to accept connection.' . PHP_EOL);
        }

        $inputStream = fread($listener, 32);
        $outputStream ??= $inputStream;
        fwrite($listener, $outputStream);
        stream_socket_shutdown($listener, STREAM_SHUT_RDWR);
        fclose($listener);
    }
}
