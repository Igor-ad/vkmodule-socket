<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket4: string implements Resolution
{
    use Helper;

    case RelayAction = Commands::RelayAction->value;
    case GetRelayStatus = Commands::GetAllStatus->value;

    public const TYPE = ModuleTypes::Socket4->value;
    // rules
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 7;

    public static function allowedInput(): array
    {
        return [];
    }

    public static function resolveInput(int $inputNumber): bool
    {
        return false;
    }
}
