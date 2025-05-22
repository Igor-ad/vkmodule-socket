<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket1: string implements Resolution
{
    use Helper;

    case SetInput = Commands::Socket1SetInput->value;
    case GetInput = Commands::Socket1GetInput->value;
    case GetAllInput = Commands::GetAllInput->value;

    public const TYPE = ModuleTypes::Socket1->value;
    // rules
    public const INPUT_START_NUMBER = 0;
    public const INPUT_END_NUMBER = 3;

    public static function allowedRelay(): array
    {
        return [];
    }

    public static function resolveRelay(int $relayNumber): bool
    {
        return false;
    }
}
