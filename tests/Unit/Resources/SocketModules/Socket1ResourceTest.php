<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket1Resource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket1Resource::class)]
class Socket1ResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '30',
                'description' => 'Socket1SetInput',
                'data' => [
                    'input' => [
                        'inputNumber' => 0,
                        'triggerAction' => 'Open',
                        'antiBounce' => 5
                    ]
                ]
            ]
        ];
        $this->assertSame($expected, Socket1Resource::make()->toArray(new Response('30000105')));
    }
}
