<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket4
{
    public const TYPE = 'Socket-4';
    public const RELAY_ACTION = Commands::RelayAction->value;
    public const GET_RELAY_STATUS = Commands::GetAllStatus->value;
    public const COMMANDS = [
        self::RELAY_ACTION,
        self::GET_RELAY_STATUS,
    ];
    // rules
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 7;

    public static function allowedRelay(): array
    {
        return range(self::RELAY_START_NUMBER, self::RELAY_END_NUMBER);
    }
}
