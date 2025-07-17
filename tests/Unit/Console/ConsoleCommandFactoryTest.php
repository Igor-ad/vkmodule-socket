<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\ApiConsoleCommand;
use Autodoctor\ModuleSocket\Console\CliConsoleCommand;
use Autodoctor\ModuleSocket\Console\ConsoleCommandFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConsoleCommandFactory::class)]
class ConsoleCommandFactoryTest extends TestCase
{
    public function testMakeCliConsoleCommand(): void
    {
        $actual = ConsoleCommandFactory::makeConsoleCommand(true);

        $this->assertInstanceOf(CliConsoleCommand::class, $actual);
    }

    public function testMakeApiConsoleCommand(): void
    {
        $actual = ConsoleCommandFactory::makeConsoleCommand(false);

        $this->assertInstanceOf(ApiConsoleCommand::class, $actual);
    }
}
