<?php declare(strict_types=1);

namespace Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\UidResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UidResource::class)]
class UidResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expectedJson = '{"success":true,"event":{"id":"04","description":"GetUid","data":{"uid":873}}}';
        $expected = [
            'success' => true,
            'event' => [
                'id' => '04',
                'description' => 'GetUid',
                'data' => [
                    'uid' => 873
                ]
            ]
        ];
        $this->assertSame($expectedJson, UidResource::make()->toJson(new Response('040369')));
        $this->assertSame($expected, UidResource::make()->toArray(new Response('040369')));
    }
}
