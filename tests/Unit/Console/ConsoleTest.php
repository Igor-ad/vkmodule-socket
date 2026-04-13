<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\Console;
use Autodoctor\ModuleSocket\Console\ConsoleCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(Console::class)]
class ConsoleTest extends TestCase
{
    use ConsoleDataProvider;

    #[DataProvider('commandDataProvider')]
    public function testConstruct(string $commandName, ?string $queryString): void
    {
        $actual = new Console($commandName, $queryString);

        $this->assertInstanceOf(Console::class, $actual);
    }

    /**
     * @throws Exception
     */
    #[DataProvider('commandWithResultDataProvider')]
    public function testInvoke(string $commandName, ?string $queryString, int|string $expectedResult): void
    {
        $mockCommand = $this->createMock(ConsoleCommand::class);
        $mockCommand->expects($this->once())
            ->method('execute')
            ->with($commandName, $queryString)
            ->willReturn($expectedResult);

        $console = Console::make($commandName, $queryString);
        $console->setCommand($mockCommand);

        $this->assertEquals($expectedResult, $console->invoke());
    }

    #[DataProvider('commandDataProvider')]
    public function testMake(string $commandName, ?string $queryString): void
    {
        $actual = Console::make($commandName, $queryString);

        $this->assertInstanceOf(Console::class, $actual);
    }
}
