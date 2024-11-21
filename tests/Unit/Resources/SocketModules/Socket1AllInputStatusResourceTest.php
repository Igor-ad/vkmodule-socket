<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket1AllInputStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket1AllInputStatusResource::class)]
class Socket1AllInputStatusResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '32',
                'description' => 'GetAllInput',
                'data' => [
                    'input' => [
                        'input0' => 'Closed',
                        'input1' => 'Closed',
                        'input2' => 'Open',
                        'input3' => 'Open',
                    ]
                ]
            ]
        ];
        $this->assertSame($expected, Socket1AllInputStatusResource::make()->toArray(new Response('3200000101')));
    }
}
