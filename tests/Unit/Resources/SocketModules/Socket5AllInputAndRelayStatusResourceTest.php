<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket5AllInputAndRelayStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket5AllInputAndRelayStatusResource::class)]
class Socket5AllInputAndRelayStatusResourceTest extends TestCase
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
                        'input2' => 'Open',
                        'input3' => 'Open',
                    ],
                    'relay' => [
                        'relay0' => 'Off',
                        'relay1' => 'Off',
                        'relay2' => 'On',
                        'relay3' => 'On',
                    ]
                ]
            ]
        ];
        $this->assertSame(
            $expected,
            Socket5AllInputAndRelayStatusResource::make()->toArray(new Response('230000010100000101'))
        );
    }
}
