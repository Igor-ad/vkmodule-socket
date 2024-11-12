<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum SocketGiant
{
    const TYPE = 'Socket-Giant';
    const SET_INPUT = Commands::SET_INPUT->value;
    const GET_INPUT = Commands::GET_INPUT->value;
    const RELAY_ACTION = Commands::RELAY_ACTION->value;
    const GET_ALL_STATUS = Commands::GET_ALL_STATUS->value;
    const RELAY_GROUP_ACTION = Commands::RELAY_GROUP_ACTION->value;
    const COMMANDS = [
        self::SET_INPUT,
        self::GET_INPUT,
        self::RELAY_ACTION,
        self::GET_ALL_STATUS,
        self::RELAY_GROUP_ACTION,
    ];
    // rules
    const INPUT_START_NUMBER = 0;
    const INPUT_END_NUMBER = 15;
    const RELAY_START_NUMBER = 0;
    const RELAY_END_NUMBER = 15;

    public static function allowedInput(): array
    {
        return range(self::INPUT_START_NUMBER, self::INPUT_END_NUMBER);
    }

    public static function allowedRelay(): array
    {
        return range(self::RELAY_START_NUMBER, self::RELAY_END_NUMBER);
    }
}
