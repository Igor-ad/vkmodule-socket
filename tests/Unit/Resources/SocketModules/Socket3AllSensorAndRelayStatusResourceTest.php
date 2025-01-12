<?php

declare(strict_types=1);

namespace Tests\Unit\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket3AllSensorAndRelayStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket3AllSensorAndRelayStatusResource::class)]
class Socket3AllSensorAndRelayStatusResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '44',
                'description' => 'Socket3GetAllStatus',
                'data' => [
                    'input' => [
                        'sensor0' => [
                            'sign' => '+',
                            'temperature' => 19,
                        ],
                        'sensor1' => [
                            'sign' => '+',
                            'temperature' => 24,
                        ],
                    ],
                    'relay' => [
                        'relay0' => 'Off',
                        'relay1' => 'Off',
                    ]
                ]
            ]
        ];

        $this->assertSame(
            $expected,
            Socket3AllSensorAndRelayStatusResource::make()->toArray(new Response('4413180000'))
        );
    }
}
