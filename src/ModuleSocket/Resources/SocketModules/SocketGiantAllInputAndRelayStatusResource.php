<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * data:
 *      0 Byte Status of digital inputs 15...8
 *          x000 0000 Status bit of input #15: 0–Closed; 1–Open;
 *      ….
 *          0000 000x Status bit of input #8: 0–Closed; 1–Open;
 *
 *      1 Byte Status of digital inputs 7...0
 *          x000 0000 Status bit of input #7: 0–Closed; 1–Open;
 *      ….
 *          0000 000x Status bit of input #0: 0–Closed; 1–Open;
 *
 *      2 Byte Relay 15...8 Status
 *          x000 0000 Status bit for relay #15: 0–Off; 1–On;
 *      ….
 *          0000 000x Status bit for relay #8: 0–Off; 1–On;
 *
 *      3 Byte Relay 7...0 Status
 *          x000 0000 Status bit for relay #7: 0–Off; 1–On;
 *      ….
 *          0000 000x Status bit for relay #0: 0–Off; 1–On;
 */
class SocketGiantAllInputAndRelayStatusResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'input0' => $this->inputStatusToSting(bitMask($response->getItem(0), 7)),
                    'input1' => $this->inputStatusToSting(bitMask($response->getItem(0), 6)),
                    'input2' => $this->inputStatusToSting(bitMask($response->getItem(0), 5)),
                    'input3' => $this->inputStatusToSting(bitMask($response->getItem(0), 4)),
                    'input4' => $this->inputStatusToSting(bitMask($response->getItem(0), 3)),
                    'input5' => $this->inputStatusToSting(bitMask($response->getItem(0), 2)),
                    'input6' => $this->inputStatusToSting(bitMask($response->getItem(0), 1)),
                    'input7' => $this->inputStatusToSting(bitMask($response->getItem(0), 0)),
                    'input8' => $this->inputStatusToSting(bitMask($response->getItem(1), 7)),
                    'input9' => $this->inputStatusToSting(bitMask($response->getItem(1), 6)),
                    'input10' => $this->inputStatusToSting(bitMask($response->getItem(1), 5)),
                    'input11' => $this->inputStatusToSting(bitMask($response->getItem(1), 4)),
                    'input12' => $this->inputStatusToSting(bitMask($response->getItem(1), 3)),
                    'input13' => $this->inputStatusToSting(bitMask($response->getItem(1), 2)),
                    'input14' => $this->inputStatusToSting(bitMask($response->getItem(1), 1)),
                    'input15' => $this->inputStatusToSting(bitMask($response->getItem(1), 0)),
                ],
                'relay' => [
                    'relay0' => $this->relayStatusToSting(bitMask($response->getItem(2), 7)),
                    'relay1' => $this->relayStatusToSting(bitMask($response->getItem(2), 6)),
                    'relay2' => $this->relayStatusToSting(bitMask($response->getItem(2), 5)),
                    'relay3' => $this->relayStatusToSting(bitMask($response->getItem(2), 4)),
                    'relay4' => $this->relayStatusToSting(bitMask($response->getItem(2), 3)),
                    'relay5' => $this->relayStatusToSting(bitMask($response->getItem(2), 2)),
                    'relay6' => $this->relayStatusToSting(bitMask($response->getItem(2), 1)),
                    'relay7' => $this->relayStatusToSting(bitMask($response->getItem(2), 0)),
                    'relay8' => $this->relayStatusToSting(bitMask($response->getItem(3), 7)),
                    'relay9' => $this->relayStatusToSting(bitMask($response->getItem(3), 6)),
                    'relay10' => $this->relayStatusToSting(bitMask($response->getItem(3), 5)),
                    'relay11' => $this->relayStatusToSting(bitMask($response->getItem(3), 4)),
                    'relay12' => $this->relayStatusToSting(bitMask($response->getItem(3), 3)),
                    'relay13' => $this->relayStatusToSting(bitMask($response->getItem(3), 2)),
                    'relay14' => $this->relayStatusToSting(bitMask($response->getItem(3), 1)),
                    'relay15' => $this->relayStatusToSting(bitMask($response->getItem(3), 0)),
                ]
            ]
        ];
    }
}
