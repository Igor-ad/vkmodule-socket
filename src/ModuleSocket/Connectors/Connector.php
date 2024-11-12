<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

interface Connector
{
    /**
     * @return resource
     */
    public function getConnector();
}
