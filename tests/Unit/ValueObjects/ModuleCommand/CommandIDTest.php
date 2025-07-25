<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\ModuleCommand;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandID::class)]
class CommandIDTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(CommandID::class, new CommandID('20'));
    }

    public function testToStream(): void
    {
        $commandId = new CommandID('23');
        $expected = chr(hexdec('23'));

        $this->assertSame($expected, $commandId->toStream());
    }

    public function testToString(): void
    {
        $commandId = new CommandID('23');
        $expected = '23';

        $this->assertSame($expected, $commandId->toString());
    }

    public function testIsEqual(): void
    {
        $commandId = new CommandID('21');

        $this->assertTrue($commandId->isEqual(new CommandID('21')));
    }
}
