<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use GuzzleHttp\Client;

class HttpConnector extends AbstractConnector
{
    protected function setConnector(string $host, int $port = 9761, float $timeout = null): void
    {
        $this->connector = new Client([$host, $timeout]);
    }
}
