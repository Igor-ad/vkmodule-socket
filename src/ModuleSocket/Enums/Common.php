<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Common
{
    const CONNECT = Commands::CheckConnect->value;
    const REBOOT = Commands::RebootController->value;
    const FIRMWARE = Commands::GetFirmware->value;
    const UID = Commands::GetUid->value;
    const UNKNOWN = Commands::UnknownCommand->value;
    const COMMANDS = [
        self::CONNECT,
        self::REBOOT,
        self::FIRMWARE,
        self::UID,
    ];
    // rules
    const ON = 1;
    const OFF = 0;
    const POSSIBLE_RELAY_ACTIONS = [self::ON, self::OFF];
    const OPEN = 1;
    const CLOSED = 0;
    const POSSIBLE_INPUT_ACTIONS = [self::OPEN, self::CLOSED];
    const MIN_INTERVAL = 0;
    const MAX_INTERVAL = 255;
    const MIN_ANTI_BOUNCE = 0;
    const MAX_ANTI_BOUNCE = 255;
}
