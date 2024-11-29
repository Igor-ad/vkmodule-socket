<?php declare(strict_types=1);

namespace Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\CardReaders\MifareResource;
use Autodoctor\ModuleSocket\Resources\Resource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MifareResource::class)]
class MifareResourceTest extends TestCase
{
    protected static Resource $resource;

    public static function setUpBeforeClass(): void
    {
        self::$resource = MifareResource::make();
    }

    public function testToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '10',
                'description' => 'MifareCard',
                'data' => [
                    'cardFlag' => 'Mifare',
                    'cardType' => 'UltraLight',
                    'cardId' => '12345678901234',
                ],
            ],
        ];

        $this->assertSame($expected, self::$resource->toArray(new Response('10440012345678901234')));

        $expected = [
            'success' => true,
            'event' => [
                'id' => '10',
                'description' => 'MifareCard',
                'data' => [
                    'cardFlag' => 'Mifare',
                    'cardType' => 'S50',
                    'cardId' => '00000012345678',
                ],
            ],
        ];

        $this->assertSame($expected, self::$resource->toArray(new Response('10040012345678')));
    }

    public function testGetCardType(): void
    {
        $expected = 'UltraLight';

        $this->assertSame($expected, self::$resource->getCardType('4400'));

        $expected = 'S50';

        $this->assertSame($expected, self::$resource->getCardType('0400'));

        $expected = 'S70';

        $this->assertSame($expected, self::$resource->getCardType('0200'));

        $expected = 'UnknownCardType';

        $this->assertSame($expected, self::$resource->getCardType('0000'));
    }

    public function testGetCardId(): void
    {
        $expected = '12345678901234';

        $this->assertSame($expected, self::$resource->getCardId(['12', '34', '56', '78', '90', '12', '34']));

        $expected = '00000012345678';

        $this->assertSame($expected, self::$resource->getCardId(['12', '34', '56', '78']));
    }

    public function testGetCardFlag(): void
    {
        $expected = 'EM-marine';

        $this->assertSame($expected, self::$resource->getCardFlag('1f'));

        $expected = 'Mifare';

        $this->assertSame($expected, self::$resource->getCardFlag('10'));

        $expected = 'UnknownFlag';

        $this->assertSame($expected, self::$resource->getCardFlag('11'));
    }
}
