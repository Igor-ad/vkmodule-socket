<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\Socket5;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

/**
 * Module "Socket-5"  (4 inputs, 4 relays 240V 10A)
 */
final class Socket5Formatter extends CommonFormatter
{
    public static function inputSetup(Input $inputObject): Command
    {
        return new Command(new CommandID(Socket5::SET_INPUT), $inputObject);
    }

    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(Socket5::GET_ALL_STATUS));
    }

    public static function getInputStatus(InputStatus $inputObject): Command
    {
        return new Command(new CommandID(Socket5::GET_INPUT), $inputObject);
    }

    public static function relayAction(Relay $relayObject): Command
    {
        return new Command(new CommandID(Socket5::RELAY_ACTION), $relayObject);
    }
}