<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2RelayActionResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket2RelayActionResource::class)]
class Socket2RelayActionResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '22',
                'description' => 'RelayAction',
                'data' => [
                    'relay' => [
                        'relayNumber' => 0,
                        'action' => 'On',
                        'interval' => 80,
                    ],
                ]
            ]
        ];

        $this->assertSame(
            $expected,
            Socket2RelayActionResource::make()->toArray(new Response('22000150'))
        );
    }
}
