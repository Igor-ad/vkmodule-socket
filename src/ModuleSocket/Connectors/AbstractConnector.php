<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

abstract class AbstractConnector implements Connector
{
    protected const CONNECT_TIMEOUT = 60;

    /**
     * @var false|resource $connector
     */
    protected $connector;

    public function __construct(string $host, int $port = 9761, float $timeout = null)
    {
        $timeout ??= $this->getTimeout();
        $this->setConnector($host, $port, $timeout);
    }

    abstract protected function setConnector(string $host, int $port = 9761, float $timeout = null): void;

    protected function getTimeout(): float
    {
        $timeout = ini_get('default_socket_timeout') ?: static::CONNECT_TIMEOUT;

        return (float)$timeout;
    }

    public function getConnector()
    {
        return $this->connector;
    }

    public function finalize(): void
    {
        if ($this->connector !== false) {
            stream_socket_shutdown($this->connector, STREAM_SHUT_RDWR);
            $this->connector = false;
        }
    }

    public function __destruct()
    {
        $this->finalize();
    }
}
