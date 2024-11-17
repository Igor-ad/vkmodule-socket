<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class InputTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function inputInit(): Input
    {
        return new Input(0, 1, 5);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function test__construct(): void
    {
        $input = new Input(0, 1, 5);
        $this->assertTrue(is_a($input, Input::class));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testIsEqual(): void
    {
        $anotherInput = new Input(0, 1, 5);
        $this->assertTrue($this->inputInit()->isEqual($anotherInput));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToArray(): void
    {
        $expected = [
            'input' => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ]
        ];
        $this->assertSame($expected, $this->inputInit()->toArray());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToJson():void
    {
        $expected = '{"input":{"inputNumber":0,"action":1,"antiBounce":10}}';
        $this->assertSame($expected, $this->inputInit()->toJson());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToStream(): void
    {
        $expected = chr(0) . chr(1) . chr(5);
        $this->assertSame($expected, $this->inputInit()->toStream());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToString(): void
    {
        $expected = hexFormat(0) . hexFormat(1) . hexFormat(5);
        $this->assertSame($expected, $this->inputInit()->toString());
    }

    public function testInputClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Input::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
