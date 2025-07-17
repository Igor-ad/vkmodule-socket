<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;

/**
 * id:
 *      0 byte 0x1F - EM-marine card indicator byte;
 * data:
 *      1 byte 0xXX - Card manufacturer identifier
 *      2-5 byte 0xXX...0xXX - 4 Card code bytes
 */
class EmMarineResource extends MifareResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'cardFlag' => $this->getCardFlag($response->getEventId()),
                'cardVendor' => $response->getEventDataItem(0),
                'cardId' => implode(array_slice($response->getEventData(), 1, 4)),
            ],
        ];
    }
}
