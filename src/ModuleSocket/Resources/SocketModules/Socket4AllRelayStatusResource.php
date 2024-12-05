<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * data:
 *       0 Byte Relay #0: 1–On; 0–Off;
 *       1 Byte Relay #1: 1–On; 0–Off;
 *       2 Byte Relay #2: 1–On; 0–Off;
 *       3 Byte Relay #3: 1–On; 0–Off;
 *       4 Byte Relay #4: 1–On; 0–Off;
 *       5 Byte Relay #5: 1–On; 0–Off;
 *       6 Byte Relay #6: 1–On; 0–Off;
 *       7 Byte Relay #7: 1–On; 0–Off;
 */
class Socket4AllRelayStatusResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'relay' => [
                    'relay0' => $this->relayStatusToSting($response->getItem(0)),
                    'relay1' => $this->relayStatusToSting($response->getItem(1)),
                    'relay2' => $this->relayStatusToSting($response->getItem(2)),
                    'relay3' => $this->relayStatusToSting($response->getItem(3)),
                    'relay4' => $this->relayStatusToSting($response->getItem(4)),
                    'relay5' => $this->relayStatusToSting($response->getItem(5)),
                    'relay6' => $this->relayStatusToSting($response->getItem(6)),
                    'relay7' => $this->relayStatusToSting($response->getItem(7)),
                ]
            ]
        ];
    }
}
