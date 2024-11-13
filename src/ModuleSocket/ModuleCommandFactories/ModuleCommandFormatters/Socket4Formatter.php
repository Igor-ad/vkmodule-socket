<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\Socket4;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

/**
 * Module "Socket-4" (8 relays 240V 10A)
 */
final class Socket4Formatter extends CommonFormatter
{
    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(Socket4::GET_RELAY_STATUS));
    }

    public static function relayAction(Relay $relay): Command
    {
        return new Command(new CommandID(Socket4::RELAY_ACTION), $relay);
    }
}
