<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket4
{
    const TYPE = 'Socket-4';
    const RELAY_ACTION = Commands::RELAY_ACTION->value;
    const GET_RELAY_STATUS = Commands::GET_ALL_STATUS->value;
    const COMMANDS = [
        self::RELAY_ACTION,
        self::GET_RELAY_STATUS,
    ];
    // rules
    const RELAY_START_NUMBER = 0;
    const RELAY_END_NUMBER = 7;

    public static function allowedRelay(): array
    {
        return range(self::RELAY_START_NUMBER, self::RELAY_END_NUMBER);
    }
}
