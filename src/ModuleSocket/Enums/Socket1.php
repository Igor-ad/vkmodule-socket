<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket1
{
    public const TYPE = 'Socket-1';
    public const SET_INPUT = Commands::Socket1SetInput->value;
    public const GET_INPUT = Commands::Socket1GetInput->value;
    public const GET_ALL_INPUT = Commands::GetAllInput->value;
    public const COMMANDS = [
        self::SET_INPUT,
        self::GET_INPUT,
        self::GET_ALL_INPUT,
    ];
    // rules
    public const INPUT_START_NUMBER = 0;
    public const INPUT_END_NUMBER = 3;

    public static function allowedInput(): array
    {
        return range(self::INPUT_START_NUMBER, self::INPUT_END_NUMBER);
    }
}
