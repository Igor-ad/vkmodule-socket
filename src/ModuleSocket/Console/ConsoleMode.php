<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

enum ConsoleMode: string
{
    case Cli = 'cli';
    case Api = 'api';

    private const API_PREFIX = 'api_';

    /** Default for callers that do not pass a mode: the 'api_' prefix of a command name selects the API mode. */
    public static function fromCommandName(string $commandName): self
    {
        return str_starts_with($commandName, self::API_PREFIX) ? self::Api : self::Cli;
    }
}
