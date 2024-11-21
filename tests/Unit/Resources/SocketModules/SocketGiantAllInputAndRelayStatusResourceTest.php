<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\SocketGiantAllInputAndRelayStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SocketGiantAllInputAndRelayStatusResource::class)]
class SocketGiantAllInputAndRelayStatusResourceTest extends TestCase
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
                        'input2' => 'Closed',
                        'input3' => 'Closed',
                        'input4' => 'Closed',
                        'input5' => 'Closed',
                        'input6' => 'Closed',
                        'input7' => 'Closed',
                        'input8' => 'Closed',
                        'input9' => 'Closed',
                        'input10' => 'Closed',
                        'input11' => 'Closed',
                        'input12' => 'Closed',
                        'input13' => 'Closed',
                        'input14' => 'Closed',
                        'input15' => 'Closed',
                    ],
                    'relay' => [
                        'relay0' => 'Off',
                        'relay1' => 'Off',
                        'relay2' => 'Off',
                        'relay3' => 'Off',
                        'relay4' => 'Off',
                        'relay5' => 'Off',
                        'relay6' => 'Off',
                        'relay7' => 'Off',
                        'relay8' => 'Off',
                        'relay9' => 'Off',
                        'relay10' => 'Off',
                        'relay11' => 'Off',
                        'relay12' => 'Off',
                        'relay13' => 'Off',
                        'relay14' => 'Off',
                        'relay15' => 'Off',
                    ]
                ]
            ]
        ];
        $this->assertSame(
            $expected,
            SocketGiantAllInputAndRelayStatusResource::make()->toArray(new Response('2300000000'))
        );
    }
}
