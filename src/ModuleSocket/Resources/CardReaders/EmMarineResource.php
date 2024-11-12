<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;

/**
 * 0x1F - EM-marine card indicator byte;
 * 0xXX - Card manufacturer identifier
 * 0xXX...0xXX - 4 Card code bytes
 */
class EmMarineResource extends MifareResource
{
    public function toArray(Response $response): array
    {
        return [
            'success' => $response->success,
            'flagEM-marine' => $response->id,
            'data' => [
                'cardVendor' => $response->getItem(0),
                'cardId' => implode(array_slice($response->data, 1)),
            ],
        ];
    }
}
