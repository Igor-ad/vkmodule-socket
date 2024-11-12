<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Common
{
    const CONNECT = Commands::CHECK_CONNECT->value;
    const REBOOT = Commands::REBOOT_CONTROLLER->value;
    const FIRMWARE = Commands::GET_FIRMWARE->value;
    const UID = Commands::GET_UID->value;
    const UNKNOWN = Commands::UNKNOWN_COMMAND->value;
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
