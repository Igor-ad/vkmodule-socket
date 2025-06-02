<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

abstract class AbstractConnector implements Connector
{
    protected const CONNECT_TIMEOUT = 2;

    /**
     * @var false|resource $connector
     */
    protected $connector;
    protected float $timeout;

    public function __construct(string $host, int $port = 9761, ?float $timeout = null)
    {
        $this->timeout = $timeout ?? static::CONNECT_TIMEOUT;
        $this->setConnector($host, $port, $this->timeout);
    }

    abstract protected function setConnector(string $host, int $port = 9761, ?float $timeout = null): void;

    public function getConnector()
    {
        return $this->connector;
    }

    private function finalize(): void
    {
        if ($this->connector !== false) {
            stream_socket_shutdown($this->connector, STREAM_SHUT_RDWR);
            fclose($this->connector);
            $this->connector = false;
        }
    }

    public function __destruct()
    {
        $this->finalize();
    }
}
