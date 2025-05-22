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
    public static function inputSetup(Input $input): Command
    {
        return new Command(new CommandID(Socket5::SetInput->value), $input);
    }

    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(Socket5::GetAllStatus->value));
    }

    public static function getInputStatus(InputStatus $inputStatus): Command
    {
        return new Command(new CommandID(Socket5::GetInput->value), $inputStatus);
    }

    public static function relayAction(Relay $relay): Command
    {
        return new Command(new CommandID(Socket5::RelayAction->value), $relay);
    }
}
