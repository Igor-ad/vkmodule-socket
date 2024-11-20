<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class InputTest extends TestCase
{
    protected Input $input;

    /**
     * @throws InvalidInputParameterException
     */
    protected function setUp(): void
    {
        $this->input = new Input(0, 1, 5);
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Input::class, $this->input);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testIsEqual(): void
    {
        $anotherInput = new Input(0, 1, 5);
        $this->assertTrue($this->input->isEqual($anotherInput));
    }

    public function testToArray(): void
    {
        $expected = [
            'input' => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ]
        ];
        $this->assertSame($expected, $this->input->toArray());
    }

    public function testToJson(): void
    {
        $expected = '{"input":{"inputNumber":0,"action":1,"antiBounce":5}}';
        $this->assertSame($expected, $this->input->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(0) . chr(1) . chr(5);
        $this->assertSame($expected, $this->input->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(0) . hexFormat(1) . hexFormat(5);
        $this->assertSame($expected, $this->input->toString());
    }

    public function testInputClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Input::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
