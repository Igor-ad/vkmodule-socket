<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket3: string implements Resolution
{
    use Helper;

    case GetTemp0 = Commands::GetTemperatureSensor0->value;
    case GetTemp1 = Commands::GetTemperatureSensor1->value;
    case RelayAction = Commands::Socket3RelayAction->value;
    case GetAllStatus = Commands::Socket3GetAllStatus->value;

    public const TYPE = ModuleTypes::Socket3->value;
    // rules
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 1;
    public const NEG_MIN_TEMPERATURE = 55;
    public const MAX_TEMPERATURE = 125;

    public static function allowedInput(): array
    {
        return [];
    }

    public static function resolveInput(int $inputNumber): bool
    {
        return false;
    }
}
