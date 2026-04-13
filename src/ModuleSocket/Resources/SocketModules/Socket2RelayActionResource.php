<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * data:
 *       0 Byte Relay number (0...1)
 *       1 Byte 1 – On; 0 – Off
 *       2 Byte On duration: 1-255 - 100ms intervals, 0 - constantly on.
 */
class Socket2RelayActionResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                CommandDataRootKey::Relay->value => [
                    'relayNumber' => hexdec($response->getEventDataItem(0)),
                    'action' => $this->relayStatusToSting($response->getEventDataItem(1)),
                    'interval' => hexdec($response->getEventDataItem(2)),
                ],
            ]
        ];
    }
}
