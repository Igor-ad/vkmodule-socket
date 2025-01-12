<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use GuzzleHttp\Client;

interface Connector
{
    /**
     * @return resource|Client
     */
    public function getConnector();
}
