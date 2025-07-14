<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Commands: string
{
    // Common
    case CheckConnect = '01';
    case RebootController = '02';
    case GetFirmware = '03';
    case GetUid = '04';
    case UnknownCommand = '0f';

    // Socket-1
    case Socket1SetInput = '30';
    case Socket1GetInput = '31'; // event id = 30; event id = 31(auto generate with out request)
    case GetAllInput = '32';

    // Socket-2, Socket-2W, Socket-4, Socket-5, Socket-Giant
    case SetInput = '20';
    case GetInput = '21'; // event id = 20; event id = 21(auto generate with out request)
    case RelayAction = '22';
    case GetAllStatus = '23';

    // Socket-2W
    case GetAnalogInput = '24';

    // Socket-3
    case GetTemperatureSensor0 = '41';
    case GetTemperatureSensor1 = '42';
    case Socket3RelayAction = '43';
    case Socket3GetAllStatus = '44';

    // Socket-Giant
    case RelayGroupAction = '25';

    // Card Readers
    case EmMarineCard = '1f';
    case MifareCard = '10';
    case ManagingOnlineStatus = '1c';
    case ManagingOfflineStatus = '1b';
    case ManagingResponseWaiting = '1d';
    case ManagingResponseStatus = '1e';

    public static function commands(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function description(string $id): string
    {
        return self::tryFrom($id)->name ?? sprintf(" '%s' is an invalid module command ID", $id);
    }
}
