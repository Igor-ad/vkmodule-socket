<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\HttpConnector;

class TransceiverFactory
{
    public static function transceiverInit(
        Connector $connector,
        string    $streamData = '',
        int       $attempts = 3
    ): Transceiver
    {
        return match ($connector::class) {
            HttpConnector::class => new HttpTransceiver($connector, $streamData, $attempts),
            default => new TcpTransceiver($connector, $streamData, $attempts),
        };
    }
}