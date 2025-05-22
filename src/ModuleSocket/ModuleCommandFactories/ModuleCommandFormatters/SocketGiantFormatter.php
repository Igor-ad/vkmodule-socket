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
    public static function relayGroupAction(RelayGroup $relayGroup): Command
    {
        return new Command(new CommandID(SocketGiant::RelayGroupAction->value), $relayGroup);
    }

    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(SocketGiant::GetAllStatus->value));
    }

    public static function getInputStatus(InputStatus $inputStatus): Command
    {
        return new Command(new CommandID(SocketGiant::GetInput->value), $inputStatus);
    }

    public static function setupInput(Input $input): Command
    {
        return new Command(new CommandID(SocketGiant::SetInput->value), $input);
    }

    public static function relayAction(Relay $relay): Command
    {
        return new Command(new CommandID(SocketGiant::RelayAction->value), $relay);
    }
}
