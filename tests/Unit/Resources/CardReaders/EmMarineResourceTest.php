<?php declare(strict_types=1);

namespace Resources\CardReaders;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\CardReaders\EmMarineResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EmMarineResource::class)]
class EmMarineResourceTest extends TestCase
{
    public function testToArray(): void
    {
        $expected = [
            'success' => true,
            'flagEM-marine' => true,
            'data' => [
                'cardVendor' => 'ab',
                'cardId' => '12345678',
            ],
        ];
        $this->assertSame($expected, EmMarineResource::make()->toArray(new Response('1fab12345678')));
    }
}
