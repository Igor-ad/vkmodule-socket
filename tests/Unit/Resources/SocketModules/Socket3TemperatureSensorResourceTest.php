<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket3TemperatureSensorResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket3TemperatureSensorResource::class)]
class Socket3TemperatureSensorResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '41',
                'description' => 'GetTemperatureSensor0',
                'data' => [
                    'input' => [
                        'sensor0' => [
                            'sign' => '+',
                            'temperature' => 21,
                        ],
                    ]
                ]
            ]
        ];

        $this->assertSame(
            $expected,
            Socket3TemperatureSensorResource::make()->toArray(new Response('4115'))
        );
    }
}
