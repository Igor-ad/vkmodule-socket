<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;

/**
 * data:
 *       0 Byte High Byte (Hi);
 *       1 Byte Low Byte (Lo);
 */
class UidResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'uid' => hexdec($response->getItem(0) . $response->getItem(1)),
            ],
        ];
    }
}
