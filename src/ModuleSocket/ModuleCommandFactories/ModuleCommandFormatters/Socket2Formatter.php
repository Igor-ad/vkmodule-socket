<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\Socket2;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

/**
 * Module       "Socket-2"  (2 inputs, 2 relays 240V 10A)
 * Wi-Fi module "Socket-2W" (2 inputs, 2 relays 240V 10A)
 */
final class Socket2Formatter extends CommonFormatter
{
    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(Socket2::GET_ALL_STATUS));
    }

    public static function getAnalogInput(): Command
    {
        return new Command(new CommandID(Socket2::GET_ANALOG_INPUT));
    }

    public static function getInputStatus(InputStatus $inputStatus): Command
    {
        return new Command(new CommandID(Socket2::GET_INPUT), $inputStatus);
    }

    public static function inputSetup(Input $input): Command
    {
        return new Command(new CommandID(Socket2::SET_INPUT), $input);
    }

    public static function relayAction(Relay $relay): Command
    {
        return new Command(new CommandID(Socket2::RELAY_ACTION), $relay);
    }
}
