<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RelayTest extends TestCase
{
    protected Relay $relay;

    /**
     * @throws InvalidInputParameterException
     */
    protected function setUp(): void
    {
        $this->relay = new Relay(0, 1, 10);
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Relay::class, $this->relay);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testIsEqual(): void
    {
        $anotherRelay = new Relay(0, 1, 10);
        $this->assertTrue($this->relay->isEqual($anotherRelay));
    }

    public function testToArray(): void
    {
        $expected = [
            'relay' => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 10,
            ]
        ];
        $this->assertSame($expected, $this->relay->toArray());
    }

    public function testToJson(): void
    {
        $expected = '{"relay":{"relayNumber":0,"action":1,"interval":10}}';
        $this->assertSame($expected, $this->relay->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(0) . chr(1) . chr(10);
        $this->assertSame($expected, $this->relay->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(0) . hexFormat(1) . hexFormat(10);
        $this->assertSame($expected, $this->relay->toString());
    }

    public function testRelayClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Relay::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
