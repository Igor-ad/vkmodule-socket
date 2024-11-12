<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use Autodoctor\ModuleSocket\ValueObjects\Module;
use GuzzleHttp\Client;

class HttpConnector extends AbstractConnector
{
    protected $connector;

    public function __construct(Module $module, float $timeout = null)
    {
        $timeout = $timeout ?? $this->getTimeout();

        $this->connector = new Client([$module->host, $timeout]);
    }
}
