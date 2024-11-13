<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

/**
 * Module "Socket-3" (2 DS18B20 temperature sensors, 2 relays 240V 10A)
 */
final class Socket3Formatter extends CommonFormatter
{
    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(Socket3::GET_ALL_STATUS));
    }

    public static function getSensor0(): Command
    {
        return new Command(new CommandID(Socket3::GET_TEMP_0));
    }

    public static function getSensor1(): Command
    {
        return new Command(new CommandID(Socket3::GET_TEMP_1));
    }

    public static function relayAction(Relay $relay): Command
    {
        return new Command(new CommandID(Socket3::RELAY_ACTION), $relay);
    }
}
