<?php declare(strict_types=1);

namespace Tests\Unit\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2wAnalogInputStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket2wAnalogInputStatusResource::class)]
class Socket2wAnalogInputStatusResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '24',
                'description' => 'GetAnalogInput',
                'data' => [
                    'input' => [
                        'voltage' => 0.5,
                    ]
                ]
            ]
        ];

        $this->assertSame(
            $expected,
            Socket2wAnalogInputStatusResource::make()->toArray(new Response('240200'))
        );
    }
}
