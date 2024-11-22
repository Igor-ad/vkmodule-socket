<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Resources\BaseResource;
use Autodoctor\ModuleSocket\Validator;

/**
 * data:
 *       0 Byte Temperature of sensor 0:
 *          x0000000 – high bit of temperature sign: 1-minus; 0-plus;
 *          0xxxxxxx – low 7 bits: temperature value;
 *       1 Byte Temperature of sensor 1;
 *       2 Byte Relay #0: 1–On; 0–Off;
 *       3 Byte Relay #1: 1–On; 0–Off;
 */
class Socket3AllSensorAndRelayStatusResource extends BaseResource
{
    /**
     * @throws InvalidInputParameterException
     */
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'sensor0' => [
                        'sign' => $this->signToString($response->getItem(0)),
                        'temperature' => Validator::instance()->validateTemperature(
                            data: hexdec($response->getItem(0)) & 127,
                            sensorNumber: 0,
                            sign: $this->getSign($response->getItem(0))
                        ),
                    ],
                    'sensor1' => [
                        'sign' => $this->signToString($response->getItem(1)),
                        'temperature' => Validator::instance()->validateTemperature(
                            data: hexdec($response->getItem(1)) & 127,
                            sensorNumber: 1,
                            sign: $this->getSign($response->getItem(1))
                        ),
                    ],
                ],
                'relay' => [
                    'relay0' => $this->relayStatusToSting($response->getItem(2)),
                    'relay1' => $this->relayStatusToSting($response->getItem(3)),
                ]
            ]
        ];
    }

    protected function getSign(string $data): int
    {
        return hexdec($data) >> 7;
    }

    protected function signToString(string $data): string
    {
        return $this->getSign($data) ? '-' : '+';
    }
}
