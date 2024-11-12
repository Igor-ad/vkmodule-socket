<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

class AbstractConnector implements Connector
{
    protected const CONNECT_TIMEOUT = 60;

    /**
     * @var resource $connector
     */
    protected $connector;

    protected function getTimeout(): float
    {
        $timeout = ini_get('default_socket_timeout') ?: static::CONNECT_TIMEOUT;

        return (float)$timeout;
    }

    public function getConnector()
    {
        return $this->connector;
    }

    public function __destruct()
    {
        fclose($this->connector);
        $this->connector = false;
    }
}
