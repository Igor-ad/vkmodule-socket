<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket3
{
    public const TYPE = 'Socket-3';
    public const GET_TEMP_0 = Commands::GetTemperatureSensor0->value;
    public const GET_TEMP_1 = Commands::GetTemperatureSensor1->value;
    public const RELAY_ACTION = Commands::Socket3RelayAction->value;
    public const GET_ALL_STATUS = Commands::Socket3GetAllStatus->value;
    public const COMMANDS = [
        self::GET_TEMP_0,
        self::GET_TEMP_1,
        self::RELAY_ACTION,
        self::GET_ALL_STATUS,
    ];
    // rules
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 1;
    public const NEG_MIN_TEMPERATURE = 55;
    public const MAX_TEMPERATURE = 125;

    public static function allowedRelay(): array
    {
        return [self::RELAY_START_NUMBER, self::RELAY_END_NUMBER];
    }
}
