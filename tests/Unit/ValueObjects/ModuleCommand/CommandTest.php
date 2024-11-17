<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CommandTest extends TestCase
{
    public function commandInit(): Command
    {
        return new Command(new CommandID('01'));
    }

    public function test__construct(): void
    {
        $this->assertTrue(is_a($this->commandInit(), Command::class));
    }

    public function testIsEqual(): void
    {
        $command = $this->commandInit();
        $anotherCommand = new Command(new CommandID('01'));
        $this->assertTrue($command->isEqual($anotherCommand));
    }

    public function testToArray(): void
    {
        $expected = [
            'command' => [
                'id' => '01',
                'description' => 'CheckConnect',
                'data' => null
            ]
        ];
        $this->assertSame($expected, $this->commandInit()->toArray());
    }

    public function testToJson(): void
    {
        $expected = '{"command":{"id":"01","description":"CheckConnect","data":null}}';
        $this->assertSame($expected, $this->commandInit()->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(hexdec('01'));
        $this->assertSame($expected, $this->commandInit()->toStream());
    }

    public function testCommandClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Command::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
