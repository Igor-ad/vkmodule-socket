<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Common: string
{
    case Connect = Commands::CheckConnect->value;
    case Reboot = Commands::RebootController->value;
    case Firmware = Commands::GetFirmware->value;
    case Uid = Commands::GetUid->value;

    public const UNKNOWN = Commands::UnknownCommand->value;
    // rules
    public const ON = 1;
    public const OFF = 0;
    public const POSSIBLE_RELAY_ACTIONS = [self::ON, self::OFF];
    public const OPEN = 1;
    public const CLOSED = 0;
    public const POSSIBLE_INPUT_ACTIONS = [self::OPEN, self::CLOSED];
    public const MIN_INTERVAL = 0;
    public const MAX_INTERVAL = 255;
    public const MIN_ANTI_BOUNCE = 0;
    public const MAX_ANTI_BOUNCE = 255;

    public static function commands(): array
    {
        return array_column(self::cases(), 'value');
    }
}
