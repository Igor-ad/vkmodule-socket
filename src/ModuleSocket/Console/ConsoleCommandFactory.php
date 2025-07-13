<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ConsoleCommandFactory
{
    public static function makeConsoleCommand(bool $isCli): ConsoleCommand
    {
        return match ($isCli) {
            false => new ApiConsoleCommand(),
            default => new CliConsoleCommand(),
        };
    }
}
