<?php declare(strict_types=1);

namespace Tests\Unit\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket4AllRelayStatusResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket4AllRelayStatusResource::class)]
class Socket4AllRelayStatusResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '23',
                'description' => 'GetAllStatus',
                'data' => [
                    'relay' => [
                        'relay0' => 'Off',
                        'relay1' => 'Off',
                        'relay2' => 'Off',
                        'relay3' => 'Off',
                        'relay4' => 'On',
                        'relay5' => 'On',
                        'relay6' => 'On',
                        'relay7' => 'On',
                    ]
                ]
            ]
        ];

        $this->assertSame(
            $expected,
            Socket4AllRelayStatusResource::make()->toArray(new Response('230000000001010101'))
        );
    }
}
