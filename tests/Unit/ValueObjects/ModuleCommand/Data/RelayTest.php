<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RelayTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function relayInit(): Relay
    {
        return new Relay(0, 1, 10);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function test__construct(): void
    {
        $relay = new Relay(0, 1, 10);
        $this->assertTrue(is_a($relay, Relay::class));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testIsEqual(): void
    {
        $anotherRelay = new Relay(0, 1, 10);
        $this->assertTrue($this->relayInit()->isEqual($anotherRelay));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToArray(): void
    {
        $expected = [
            'relay' => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 10,
            ]
        ];
        $this->assertSame($expected, $this->relayInit()->toArray());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToJson(): void
    {
        $expected = '{"relay":{"relayNumber":0,"action":1,"interval":10}}';
        $this->assertSame($expected, $this->relayInit()->toJson());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToStream(): void
    {
        $expected = chr(0) . chr(1) . chr(10);
        $this->assertSame($expected, $this->relayInit()->toStream());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToString(): void
    {
        $expected = hexFormat(0) . hexFormat(1) . hexFormat(10);
        $this->assertSame($expected, $this->relayInit()->toString());
    }

    public function testRelayClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Relay::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
