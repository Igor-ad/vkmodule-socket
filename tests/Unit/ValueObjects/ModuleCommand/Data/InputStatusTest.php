<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class InputStatusTest extends TestCase
{
    protected InputStatus $inputStatus;

    protected function setUp(): void
    {
        $this->inputStatus = new InputStatus(0);
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(InputStatus::class, $this->inputStatus);
    }

    public function testIsEqual(): void
    {
        $anotherInputStatus = new InputStatus(0);
        $this->assertTrue($this->inputStatus->isEqual($anotherInputStatus));
    }

    public function testToArray(): void
    {
        $expected = [
            'input' => [
                'inputNumber' => 0,
            ]
        ];
        $this->assertSame($expected, $this->inputStatus->toArray());
    }

    public function testToJson(): void
    {
        $expected = '{"input":{"inputNumber":0}}';
        $this->assertSame($expected, $this->inputStatus->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(0);
        $this->assertSame($expected, $this->inputStatus->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(0);
        $this->assertSame($expected, $this->inputStatus->toString());
    }

    public function testInputStatusClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(InputStatus::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
