<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket5
{
    const TYPE = 'Socket-5';
    const SET_INPUT = Commands::SetInput->value;
    const GET_INPUT = Commands::GetInput->value;
    const RELAY_ACTION = Commands::RelayAction->value;
    const GET_ALL_STATUS = Commands::GetAllStatus->value;
    const COMMANDS = [
        self::SET_INPUT,
        self::GET_INPUT,
        self::RELAY_ACTION,
        self::GET_ALL_STATUS,
    ];
    // rules
    const INPUT_START_NUMBER = 0;
    const INPUT_END_NUMBER = 3;
    const RELAY_START_NUMBER = 0;
    const RELAY_END_NUMBER = 3;

    public static function allowedInput(): array
    {
        return range(self::INPUT_START_NUMBER, self::INPUT_END_NUMBER);
    }

    public static function allowedRelay(): array
    {
        return range(self::RELAY_START_NUMBER, self::RELAY_END_NUMBER);
    }
}
