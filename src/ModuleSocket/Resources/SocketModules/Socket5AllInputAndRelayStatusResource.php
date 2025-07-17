<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * data:
 *       0 Byte Digital Input   #0: 0–Closed;   1–Open;
 *       1 Byte Digital Input   #1: 0–Closed;   1–Open;
 *       2 Byte Digital Input   #2: 0–Closed;   1–Open;
 *       3 Byte Digital Input   #3: 0–Closed;   1–Open;
 *       4 Byte Relay           #0: 1–On;       0–Off;
 *       5 Byte Relay           #1: 1–On;       0–Off;
 *       6 Byte Relay           #2: 1–On;       0–Off;
 *       7 Byte Relay           #3: 1–On;       0–Off
 */
class Socket5AllInputAndRelayStatusResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'input0' => $this->inputStatusToSting($response->getEventDataItem(0)),
                    'input1' => $this->inputStatusToSting($response->getEventDataItem(1)),
                    'input2' => $this->inputStatusToSting($response->getEventDataItem(2)),
                    'input3' => $this->inputStatusToSting($response->getEventDataItem(3)),
                ],
                'relay' => [
                    'relay0' => $this->relayStatusToSting($response->getEventDataItem(4)),
                    'relay1' => $this->relayStatusToSting($response->getEventDataItem(5)),
                    'relay2' => $this->relayStatusToSting($response->getEventDataItem(6)),
                    'relay3' => $this->relayStatusToSting($response->getEventDataItem(7)),

                ]
            ]
        ];
    }
}
