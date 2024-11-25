<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

class ConnectorFactory
{
    public static function connectInit(
        string  $host,
        int     $port = 9761,
        ?string $connectorType = 'TCP',
        ?int    $timeOut = 5,
    ): Connector
    {
        return match ($connectorType) {
            'HTTP' => new HttpConnector($host, $timeOut),
            default => new TcpConnector($host, $port, $timeOut),
        };
    }
}
