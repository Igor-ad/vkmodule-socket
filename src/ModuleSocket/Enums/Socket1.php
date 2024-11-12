<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket1
{
    const TYPE = 'Socket-1';
    const SET_INPUT = Commands::SOCKET1_SET_INPUT->value;
    const GET_INPUT = Commands::SOCKET1_GET_INPUT->value;
    const GET_ALL_INPUT = Commands::GET_ALL_INPUT->value;
    const COMMANDS = [
        self::SET_INPUT,
        self::GET_INPUT,
        self::GET_ALL_INPUT,
    ];
    // rules
    const INPUT_START_NUMBER = 0;
    const INPUT_END_NUMBER = 3;

    public static function allowedInput(): array
    {
        return range(self::INPUT_START_NUMBER, self::INPUT_END_NUMBER);
    }
}