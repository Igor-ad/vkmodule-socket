<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum ApiCommands: string
{
    case ApiConnection = 'api_connection';
    case ApiReboot = 'api_reboot';
    case ApiFirmware = 'api_firmware';
    case ApiUid = 'api_uid';

    case ApiFullControl = 'api_full_control';
    case ApiInputAnalog = 'api_input_analog';
    case ApiInputSetup = 'api_input_setup';
    case ApiInputStatus = 'api_input_status';
    case ApiInputTemperature0 = 'api_input_temperature0';
    case ApiInputTemperature1 = 'api_input_temperature1';
    case ApiRelayControl = 'api_relay_control';
    case ApiRelayGroupControl = 'api_relay_group_control';
    case ApiRelayOff = 'api_relay_off';
    case ApiRelayOn = 'api_relay_on';
    case ApiStatus = 'api_status';
}
