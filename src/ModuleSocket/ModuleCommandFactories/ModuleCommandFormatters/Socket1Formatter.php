<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\Socket1;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;

/**
 * Module "Socket-1" (4 digital inputs)
 */
final class Socket1Formatter extends CommonFormatter
{
    public static function getAllStatus(): Command
    {
        return new Command(new CommandID(Socket1::GetAllInput->value));
    }

    public static function getInputStatus(InputStatus $inputStatus): Command
    {
        return new Command(new CommandID(Socket1::GetInput->value), $inputStatus);
    }

    public static function inputSetup(Input $input): Command
    {
        return new Command(new CommandID(Socket1::SetInput->value), $input);
    }
}
