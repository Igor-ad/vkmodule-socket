<?php declare(strict_types=1);

namespace Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\FirmwareResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FirmwareResource::class)]
class FirmwareResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $expected = [
            'success' => true,
            'event' => [
                'id' => '03',
                'description' => 'GetFirmware',
                'data' => [
                    'controllerType' => 'Socket-3',
                    'version' => '0000',
                    'firmwareType' => 'regular',
                    'firmware' => '040000',
                ],
            ]
        ];
        $this->assertSame($expected, FirmwareResource::make()->toArray(new Response('03040000')));
    }

    public function testGetControllerType(): void
    {
        $resource = FirmwareResource::make();
        $expected = 'VRD-E';
        $this->assertSame($expected, $resource->getControllerType('1'));
        $expected = 'Socket-2';
        $this->assertSame($expected, $resource->getControllerType('2'));
        $expected = 'Socket-1';
        $this->assertSame($expected, $resource->getControllerType('3'));
        $expected = 'Socket-3';
        $this->assertSame($expected, $resource->getControllerType('4'));
        $expected = 'Socket-4';
        $this->assertSame($expected, $resource->getControllerType('5'));
        $expected = 'Socket-5';
        $this->assertSame($expected, $resource->getControllerType('6'));
        $expected = 'Socket-Giant';
        $this->assertSame($expected, $resource->getControllerType('7'));
        $expected = 'UnknownModuleType';
        $this->assertSame($expected, $resource->getControllerType('99'));
    }
}
