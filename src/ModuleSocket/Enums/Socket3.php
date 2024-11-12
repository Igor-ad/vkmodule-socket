<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket3
{
    const TYPE = 'Socket-3';
    const GET_TEMP_0 = Commands::GET_TEMPERATURE_SENSOR_0->value;
    const GET_TEMP_1 = Commands::GET_TEMPERATURE_SENSOR_1->value;
    const RELAY_ACTION = Commands::SOCKET3_RELAY_ACTION->value;
    const GET_ALL_STATUS = Commands::SOCKET3_GET_ALL_STATUS->value;
    const COMMANDS = [
        self::GET_TEMP_0,
        self::GET_TEMP_1,
        self::RELAY_ACTION,
        self::GET_ALL_STATUS,
    ];
    // rules
    const RELAY_START_NUMBER = 0;
    const RELAY_END_NUMBER = 1;
    const NEG_MIN_TEMPERATURE = 55;
    const MAX_TEMPERATURE = 125;

    public static function allowedRelay(): array
    {
        return [self::RELAY_START_NUMBER, self::RELAY_END_NUMBER];
    }
}
