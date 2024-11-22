<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\AbstractResource;

/**
 * id:
 *      0 byte 0x1F - EM-marine card indicator byte;
 * data:
 *      1 byte 0xXX - Card manufacturer identifier
 *      2-5 byte 0xXX...0xXX - 4 Card code bytes
 */
class EmMarineResource extends AbstractResource
{
    public function toArray(Response $response): array
    {
        return [
            'success' => $response->success,
            'flagEM-marine' => $response->id === '1f',
            'data' => [
                'cardVendor' => $response->getItem(0),
                'cardId' => implode(array_slice($response->data, 1, 4)),
            ],
        ];
    }
}
