<?php declare(strict_types=1);

namespace Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\AbstractResource;
use Autodoctor\ModuleSocket\Resources\RebootResource;
use Autodoctor\ModuleSocket\Resources\Resource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractResource::class)]
class AbstractResourceTest extends TestCase
{
    protected static Resource $resource;

    public static function setUpBeforeClass(): void
    {
        self::$resource = RebootResource::make();
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(Resource::class, self::$resource);
    }

    public function testToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '02',
                'description' => 'RebootController',
                'data' => null,
            ],
        ];

        $this->assertSame($expected, self::$resource->toArray(new Response('02')));
    }

    public function testToJson(): void
    {
        $expected = '{"success":true,"event":{"id":"02","description":"RebootController","data":null}}';

        $this->assertSame($expected, self::$resource->toJson(new Response('02')));
    }
}
