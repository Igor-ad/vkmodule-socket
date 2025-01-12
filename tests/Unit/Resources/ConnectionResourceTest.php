<?php

declare(strict_types=1);

namespace Tests\Unit\Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\ConnectionResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConnectionResource::class)]
class ConnectionResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '01',
                'description' => 'CheckConnect',
                'data' => [
                    'status' => 'online',
                ],
            ]
        ];

        $this->assertSame($expected, ConnectionResource::make()->toArray(new Response('01')));
    }
}
