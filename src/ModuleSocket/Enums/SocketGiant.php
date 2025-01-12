<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum SocketGiant
{
    public const TYPE = 'Socket-Giant';
    public const SET_INPUT = Commands::SetInput->value;
    public const GET_INPUT = Commands::GetInput->value;
    public const RELAY_ACTION = Commands::RelayAction->value;
    public const GET_ALL_STATUS = Commands::GetAllStatus->value;
    public const RELAY_GROUP_ACTION = Commands::RelayGroupAction->value;
    public const COMMANDS = [
        self::SET_INPUT,
        self::GET_INPUT,
        self::RELAY_ACTION,
        self::GET_ALL_STATUS,
        self::RELAY_GROUP_ACTION,
    ];
    // rules
    public const INPUT_START_NUMBER = 0;
    public const INPUT_END_NUMBER = 15;
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 15;

    public static function allowedInput(): array
    {
        return range(self::INPUT_START_NUMBER, self::INPUT_END_NUMBER);
    }

    public static function allowedRelay(): array
    {
        return range(self::RELAY_START_NUMBER, self::RELAY_END_NUMBER);
    }
}
