<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Clients\HttpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;

class TransceiverFactory
{
    public static function transceiverInit(
        Connector $connector,
        string    $streamData = '',
        int       $attempts = 3
    ): Transceiver {
        return match ($connector::class) {
            HttpConnector::class => new HttpTransceiver($connector, $streamData, $attempts),
            default => new TcpTransceiver($connector, $streamData, $attempts),
        };
    }
}
