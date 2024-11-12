<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use Autodoctor\ModuleSocket\Exceptions\ConnectorException;
use Autodoctor\ModuleSocket\ValueObjects\Module;

class ConnectorFactory
{
    /**
     * @throws ConnectorException
     */
    public static function connectInit(
        Module  $module,
        ?string $connectorType,
        ?int    $timeOut = 5,
    ): Connector
    {
        return match ($connectorType) {
            'HTTP' => new HttpConnector($module, $timeOut),
            default => new TcpConnector($module, $timeOut),
        };
    }
}
