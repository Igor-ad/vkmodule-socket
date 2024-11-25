<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * id:
 *       0 byte 0x10 - Mifare card indicator byte;
 * data:
 *       1-2 byte 0xXXXX - 2 Card type bytes (0x4400 UltraLight, 0x0400 Mifare_One(S50), 0x0200 Mifare_One(S70))
 *       3-7 byte 0xXX...0xXX - 7 Card code byte (for a 4-byte card, the senior bytes are filled with zeros)
 */
class MifareResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'cardFlag' => $this->getCardFlag($response->id),
                'cardType' => $this->getCardType(implode(array_slice($response->data, 0, 2))),
                'cardId' => $this->getCardId(array_slice($response->data, 2, 7)),
            ]
        ];
    }

    public function getCardFlag(string $id): string
    {
        return match ($id) {
            '1f' => 'EM-marine',
            '10' => 'Mifare',
            default => 'UnknownFlag'
        };
    }

    public function getCardType(string $data): string
    {
        return match ($data) {
            '4400' => 'UltraLight',
            '0400' => 'S50',
            '0200' => 'S70',
            default => 'UnknownCardType'
        };
    }

    public function getCardId(array $data): string
    {
        if (count($data) === 7) {
            return implode($data);
        }
        return '000000' . implode($data);
    }
}
