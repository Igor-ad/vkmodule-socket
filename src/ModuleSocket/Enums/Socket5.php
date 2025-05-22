<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Socket5: string implements Resolution
{
    use Helper;

    case SetInput = Commands::SetInput->value;
    case GetInput = Commands::GetInput->value;
    case RelayAction = Commands::RelayAction->value;
    case GetAllStatus = Commands::GetAllStatus->value;

    public const TYPE = ModuleTypes::Socket5->value;
    // rules
    public const INPUT_START_NUMBER = 0;
    public const INPUT_END_NUMBER = 3;
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 3;
}
