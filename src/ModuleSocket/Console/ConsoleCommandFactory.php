<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Services\ApiService;
use Autodoctor\ModuleSocket\Services\CliService;

class ConsoleCommandFactory
{
    public static function makeConsoleCommand(bool $isCli): ConsoleCommand
    {
        return match ($isCli) {
            false => new ApiConsoleCommand(ApiService::class),
            default => new CliConsoleCommand(CliService::class),
        };
    }
}
