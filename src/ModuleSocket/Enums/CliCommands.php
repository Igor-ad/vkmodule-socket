<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum CliCommands: string
{
    case Connection = 'connection';
    case Reboot = 'reboot';
    case Firmware = 'firmware';
    case Uid = 'uid';

    case CliFullControl = 'cli_full_control';
    case InputAnalog = 'input_analog';
    case InputSetup = 'input_setup';
    case InputStatus = 'input_status';
    case InputTemperature0 = 'input_temperature0';
    case InputTemperature1 = 'input_temperature1';
    case RelayControl = 'relay_control';
    case RelayGroupControl = 'relay_group_control';
    case RelayOff = 'relay_off';
    case RelayOn = 'relay_on';
    case Status = 'status';
}
