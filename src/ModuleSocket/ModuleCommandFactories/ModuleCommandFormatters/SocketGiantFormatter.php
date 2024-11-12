<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\SocketGiant;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;

/**
 * The "Socket-Giant" module (16 digital inputs, 16 relays 240V 10A)
 */
final class SocketGiantFormatter extends CommonFormatter
{
    public static function relayGroupAction(RelayGroup $relayGroupObject): Command
    {
        return new Command(new CommandID(SocketGiant::RELAY_GROUP_ACTION), $relayGroupObject);
    }

    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(SocketGiant::GET_ALL_STATUS));
    }

    public static function getInputStatus(InputStatus $inputObject): Command
    {
        return new Command(new CommandID(SocketGiant::GET_INPUT), $inputObject);
    }

    public static function setupInput(Input $inputObject): Command
    {
        return new Command(new CommandID(SocketGiant::SET_INPUT), $inputObject);
    }

    public static function relayAction(Relay $relayObject): Command
    {
        return new Command(new CommandID(SocketGiant::RELAY_ACTION), $relayObject);
    }
}