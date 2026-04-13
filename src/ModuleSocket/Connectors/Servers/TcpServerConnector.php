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

    /**
     * Long-running accept loop for ad-hoc tooling, not used by the library TCP client path.
     *
     * @codeCoverageIgnore
     */
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

    /**
     * @return bool True when a client was accepted and handled; false on accept timeout (no connection).
     */
    public function listenOnce($server, ?float $timeout = 5, ?string $outputStream = null): bool
    {
        if (!is_resource($server)) {
            throw new \InvalidArgumentException('Invalid server socket.' . PHP_EOL);
        }

        $listener = @stream_socket_accept($server, $timeout);
        if ($listener === false) {
            return false;
        }

        $inputStream = fread($listener, 32);
        $outputStream ??= $inputStream;
        fwrite($listener, $outputStream);
        stream_socket_shutdown($listener, STREAM_SHUT_RDWR);
        fclose($listener);

        return true;
    }
}
