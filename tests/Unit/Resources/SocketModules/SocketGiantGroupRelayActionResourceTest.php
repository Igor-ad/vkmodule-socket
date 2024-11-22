<?php declare(strict_types=1);

namespace Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\SocketGiantGroupRelayActionResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SocketGiantGroupRelayActionResource::class)]
class SocketGiantGroupRelayActionResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '25',
                'description' => 'RelayGroupAction',
                'data' => [
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
            SocketGiantGroupRelayActionResource::make()->toArray(new Response('250000'))
        );
    }
}
