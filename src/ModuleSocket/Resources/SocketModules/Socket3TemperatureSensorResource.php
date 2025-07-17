<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validator;

/**
 * data:
 *       0 Byte x0000000 – high bit of temperature sign: 1-minus; 0-plus;
 *              0xxxxxxx – low 7 bits: temperature value;
 */
class Socket3TemperatureSensorResource extends Socket3AllSensorAndRelayStatusResource
{
    /**
     * @throws InvalidInputParameterException
     */
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'sensor' . $this->sensorNumber($response->getEventId()) => [
                        'sign' => $this->signToString($response->getEventDataItem(0)),
                        'temperature' => Validator::instance()->validateTemperature(
                            data: hexdec($response->getEventDataItem(0)) & 127,
                            sign: $this->getSign($response->getEventDataItem(0))
                        ),
                    ]
                ]
            ]
        ];
    }

    protected function sensorNumber(string $responseId): int
    {
        return $responseId === Socket3::GetTemp0->value ? 0 : 1;
    }
}
