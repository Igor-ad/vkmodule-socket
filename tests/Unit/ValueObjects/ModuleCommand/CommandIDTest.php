<?php

declare(strict_types=1);

namespace ValueObjects\ModuleCommand;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(CommandID::class)]
class CommandIDTest extends TestCase
{
    public function test__construct(): void
    {
        $this->assertInstanceOf(CommandID::class, new CommandID('20'));
    }

    public function testToStream(): void
    {
        $commandId = new CommandID('23');
        $expected = chr(hexdec('23'));
        $this->assertSame($expected, $commandId->toStream());
    }

    public function testIsEqual(): void
    {
        $commandId = new CommandID('21');
        $this->assertTrue($commandId->isEqual(new CommandID('21')));
    }

    #[CoversNothing]
    public function testCommandIdClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(CommandId::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
