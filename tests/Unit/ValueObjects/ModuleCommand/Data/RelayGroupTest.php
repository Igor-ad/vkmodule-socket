<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RelayGroupTest extends TestCase
{
    public function relayGroupInit(): RelayGroup
    {
        return new RelayGroup('0000');
    }

    public function test__construct(): void
    {
        $relayGroup = new RelayGroup('0000');
        $this->assertTrue(is_a($relayGroup, RelayGroup::class));
    }

    public function testToArray(): void
    {
        $expected = [
            'relayGroup' => [
                'relayGroupAction' => '0000',
            ]
        ];
        $this->assertSame($expected, $this->relayGroupInit()->toArray());
    }

    public function testIsEqual(): void
    {
        $anotherRelayGroup = new RelayGroup('0000');
        $this->assertTrue($this->relayGroupInit()->isEqual($anotherRelayGroup));
    }

    public function testToJson(): void
    {
        $expected = '{"relayGroup":{"relayGroupAction":"0000"}}';
        $this->assertSame($expected, $this->relayGroupInit()->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(hexdec('0000'));
        $this->assertSame($expected, $this->relayGroupInit()->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(hexdec('0000'), 4);
        $this->assertSame($expected, $this->relayGroupInit()->toString());
    }

    public function testRelayGroupClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(RelayGroup::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
