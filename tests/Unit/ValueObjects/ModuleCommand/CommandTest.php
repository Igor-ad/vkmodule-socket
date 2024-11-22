<?php declare(strict_types=1);

namespace ValueObjects\ModuleCommand;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(Command::class)]
class CommandTest extends TestCase
{
    protected Command $command;

    protected function setUp(): void
    {
        $this->command = new Command(new CommandID('01'));
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }

    public function testIsEqual(): void
    {
        $anotherCommand = new Command(new CommandID('01'));

        $this->assertTrue($this->command->isEqual($anotherCommand));
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

        $this->assertSame($expected, $this->command->toArray());
    }

    public function testToJson(): void
    {
        $expected = '{"command":{"id":"01","description":"CheckConnect","data":null}}';

        $this->assertSame($expected, $this->command->toJson());
    }

    public function testToStream(): void
    {
        $expected = chr(hexdec('01'));

        $this->assertSame($expected, $this->command->toStream());
    }

    #[CoversNothing]
    public function testCommandClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Command::class);

        $this->assertTrue($reflectionClass->isFinal());
    }
}
