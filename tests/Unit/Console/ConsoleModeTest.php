<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\Console;
use Autodoctor\ModuleSocket\Console\ConsoleMode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConsoleMode::class)]
#[CoversClass(Console::class)]
class ConsoleModeTest extends TestCase
{
    public static function commandNameDataProvider(): array
    {
        return [
            'api prefix' => ['api_status', ConsoleMode::Api],
            'api full control' => ['api_full_control', ConsoleMode::Api],
            'logical name' => ['status', ConsoleMode::Cli],
            'cli full control' => ['cli_full_control', ConsoleMode::Cli],
            'api inside the name' => ['my_api_status', ConsoleMode::Cli],
        ];
    }

    #[DataProvider('commandNameDataProvider')]
    public function testFromCommandName(string $commandName, ConsoleMode $expected): void
    {
        $this->assertSame($expected, ConsoleMode::fromCommandName($commandName));
    }

    #[DataProvider('commandNameDataProvider')]
    public function testMakeUsesCommandNameWhenModeIsNotGiven(string $commandName, ConsoleMode $expected): void
    {
        $this->assertSame($expected, Console::make($commandName, '')->mode());
    }

    public function testMakeUsesExplicitMode(): void
    {
        $this->assertSame(ConsoleMode::Api, Console::make('relay_on', '', ConsoleMode::Api)->mode());
        $this->assertSame(ConsoleMode::Cli, Console::make('api_relay_on', '', ConsoleMode::Cli)->mode());
    }
}
