<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\AbstractResource;

/**
 * 0x10 - Mifare card indicator byte;
 * 0xXXXX - 2 Card type bytes (0x4400 UltraLight, 0x0400 Mifare_One(S50), 0x0200 Mifare_One(S70))
 * 0xXX...0xXX - 7 Card code byte (for a 4-byte card, the senior bytes are filled with zeros)
 */
class MifareResource extends AbstractResource
{
    public function toArray(Response $response): array
    {
        return [
            'success' => $response->success,
            'flagMifare' => $response->id,
            'data' => [
                'cardType' => $this->getCardType(implode(array_slice($response->data, 0, 2))),
                'cardId' => $this->getCardId(array_slice($response->data, 2)),
            ],
        ];
    }

    protected function getCardType(string $data): string
    {
        return match ($data) {
            '4400' => 'UltraLight',
            '0400' => 'S50',
            '0200' => 'S70',
            default => 'UnknownCardType'
        };
    }

    protected function getCardId(array $data): string
    {
        if (count($data) === 7) {
            return implode($data);
        }
        return '000000' . implode($data);
    }
}
