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
        return new Command(new CommandID(Socket1::GET_ALL_INPUT));
    }

    public static function getInputStatus(InputStatus $inputObject): Command
    {
        return new Command(new CommandID(Socket1::GET_INPUT), $inputObject);
    }

    public static function inputSetup(Input $inputObject): Command
    {
        return new Command(new CommandID(Socket1::SET_INPUT), $inputObject);
    }
}
