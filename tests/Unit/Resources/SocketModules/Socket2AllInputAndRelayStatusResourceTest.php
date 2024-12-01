<?php declare(strict_types=1);

namespace Tests\Unit\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2AllInputAndRelayStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket2AllInputAndRelayStatusResource::class)]
class Socket2AllInputAndRelayStatusResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '23',
                'description' => 'GetAllStatus',
                'data' => [
                    'input' => [
                        'input0' => 'Closed',
                        'input1' => 'Closed',
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
            Socket2AllInputAndRelayStatusResource::make()->toArray(new Response('2300000000'))
        );
    }
}
