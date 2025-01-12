<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * Data:
 *      0 Byte Relay 15...8 Control
 *          x000 0000 Relay #15 Control Bit: 0–Off; 1–On;
 *          0x00 0000 Relay #14 Control Bit: 0–Off; 1–On;
 *      ….
 *          0000 000x Relay #8 Control Bit: 0–Off; 1–On;
 *      1 Byte Relay 7...0 Control
 *          x000 0000 Relay #7 Control Bit: 0–Off; 1–On;
 *      ….
 *          0000 000x Relay #0 Control Bit: 0–Off; 1–On;
 */
class SocketGiantGroupRelayActionResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'relay' => [
                    'relay0' => $this->relayStatusToSting(bitMask($response->getItem(0), 7)),
                    'relay1' => $this->relayStatusToSting(bitMask($response->getItem(0), 6)),
                    'relay2' => $this->relayStatusToSting(bitMask($response->getItem(0), 5)),
                    'relay3' => $this->relayStatusToSting(bitMask($response->getItem(0), 4)),
                    'relay4' => $this->relayStatusToSting(bitMask($response->getItem(0), 3)),
                    'relay5' => $this->relayStatusToSting(bitMask($response->getItem(0), 2)),
                    'relay6' => $this->relayStatusToSting(bitMask($response->getItem(0), 1)),
                    'relay7' => $this->relayStatusToSting(bitMask($response->getItem(0), 0)),
                    'relay8' => $this->relayStatusToSting(bitMask($response->getItem(1), 7)),
                    'relay9' => $this->relayStatusToSting(bitMask($response->getItem(1), 6)),
                    'relay10' => $this->relayStatusToSting(bitMask($response->getItem(1), 5)),
                    'relay11' => $this->relayStatusToSting(bitMask($response->getItem(1), 4)),
                    'relay12' => $this->relayStatusToSting(bitMask($response->getItem(1), 3)),
                    'relay13' => $this->relayStatusToSting(bitMask($response->getItem(1), 2)),
                    'relay14' => $this->relayStatusToSting(bitMask($response->getItem(1), 1)),
                    'relay15' => $this->relayStatusToSting(bitMask($response->getItem(1), 0)),
                ],
            ]
        ];
    }
}
