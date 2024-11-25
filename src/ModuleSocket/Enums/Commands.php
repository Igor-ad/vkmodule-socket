<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;

enum Commands: string
{
    // Common
    case CHECK_CONNECT = '01';
    case REBOOT_CONTROLLER = '02';
    case GET_FIRMWARE = '03';
    case GET_UID = '04';
    case UNKNOWN_COMMAND = '0f';

    // Socket-1
    case SOCKET1_SET_INPUT = '30';
    case SOCKET1_GET_INPUT = '31'; // event id = 30; event id = 31(auto generate with out request)
    case GET_ALL_INPUT = '32';

    // Socket-2, Socket-2W, Socket-4, Socket-5, Socket-Giant
    case SET_INPUT = '20';
    case GET_INPUT = '21'; // event id = 20; event id = 21(auto generate with out request)
    case RELAY_ACTION = '22';
    case GET_ALL_STATUS = '23';

    // Socket-2W
    case GET_ANALOG_INPUT = '24';

    // Socket-3
    case GET_TEMPERATURE_SENSOR_0 = '41';
    case GET_TEMPERATURE_SENSOR_1 = '42';
    case SOCKET3_RELAY_ACTION = '43';
    case SOCKET3_GET_ALL_STATUS = '44';

    // Socket-Giant
    case RELAY_GROUP_ACTION = '25';

    // Card Readers
    case EM_MARINE_CARD = '1f';
    case MIFARE_CARD = '10';
    case MANAGING_ONLINE_STATUS = '1c';
    case MANAGING_OFFLINE_STATUS = '1b';
    case MANAGING_RESPONSE_WAITING = '1d';
    case MANAGING_RESPONSE_STATUS = '1e';

    public static function commands(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @throws ModuleException
     */
    public static function description(string $id): string
    {
        if (!in_array($id, self::commands())) {
            throw new ModuleException(
                sprintf('"%s" is not a valid module command ID.', $id)
            );
        }
        return strtolower(self::from($id)->name);
    }
}
