<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class InputStatusTest extends TestCase
{
    public function inputStatusInit(): InputStatus
    {
        return new InputStatus(0);
    }

    public function test__construct(): void
    {
        $inputStatus = new InputStatus(0);
        $this->assertTrue(is_a($inputStatus, InputStatus::class));
    }

    public function testIsEqual(): void
    {
        $anotherInputStatus = new InputStatus(0);
        $this->assertTrue($this->inputStatusInit()->isEqual($anotherInputStatus));
    }

    public function testToArray(): void
    {
        $expected = [
            'input' => [
                'inputNumber' => 0,
            ]
        ];
        $this->assertSame($expected, $this->inputStatusInit()->toArray());
    }

    public function testToJson(): void
    {
        $expected = '{"input":{"inputNumber":0}}';
        $this->assertSame($expected, $this->inputStatusInit()->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(0);
        $this->assertSame($expected, $this->inputStatusInit()->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(0);
        $this->assertSame($expected, $this->inputStatusInit()->toString());
    }

    public function testInputStatusClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(InputStatus::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
