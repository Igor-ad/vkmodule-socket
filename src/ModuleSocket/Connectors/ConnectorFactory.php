<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

class ConnectorFactory
{
    public static function connectInit(
        string  $host,
        int     $port,
        ?string $connectorType,
        ?int    $timeOut = 5,
    ): Connector
    {
        return match ($connectorType) {
            'HTTP' => new HttpConnector($host, $port, $timeOut),
            default => new TcpConnector($host, $port, $timeOut),
        };
    }
}
