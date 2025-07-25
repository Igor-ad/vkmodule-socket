<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelayGroup::class)]
class RelayGroupTest extends TestCase
{
    protected RelayGroup $relayGroup;

    protected function setUp(): void
    {
        $this->relayGroup = new RelayGroup('0000');
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(RelayGroup::class, $this->relayGroup);

        $this->expectException(InvalidInputParameterException::class);
        new RelayGroup('ffff1d');
    }

    public function testToArray(): void
    {
        $expected = [
            'relayGroup' => [
                'relayGroupAction' => '0000',
            ]
        ];

        $this->assertSame($expected, $this->relayGroup->toArray());
    }

    public function testIsEqual(): void
    {
        $anotherRelayGroup = new RelayGroup('0000');

        $this->assertTrue($this->relayGroup->isEqual($anotherRelayGroup));
    }

    public function testToStream(): void
    {
        $expected = chr(hexdec('0000'));

        $this->assertSame($expected, $this->relayGroup->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(hexdec('0000'), 4);

        $this->assertSame($expected, $this->relayGroup->toString());
    }
}
