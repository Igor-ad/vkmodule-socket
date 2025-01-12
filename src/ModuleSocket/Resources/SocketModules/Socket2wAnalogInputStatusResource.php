<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * data:
 *       0 Byte High Byte of voltage value;
 *       1 Byte Low Byte of voltage value.
 *  The input voltage should be no more than one Volt.
 */
class Socket2wAnalogInputStatusResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'voltage' => hexdec($response->getItem(0) . $response->getItem(1)) / 1024,
                ]
            ]
        ];
    }
}
