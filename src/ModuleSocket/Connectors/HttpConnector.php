<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use GuzzleHttp\Client;

class HttpConnector implements Connector
{
    protected Client $connector;

    public function __construct(string $host, float $timeout = null)
    {
        $this->setConnector($host, $timeout);
    }

    protected function setConnector(string $host, float $timeout = null): void
    {
        $this->connector = new Client([$host, $timeout]);
    }

    public function getConnector(): Client
    {
        return $this->connector;
    }
}
