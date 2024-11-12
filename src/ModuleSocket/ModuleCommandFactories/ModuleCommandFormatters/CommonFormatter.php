<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;

class CommonFormatter
{
    public static function checkConnect(): Command
    {
        return new Command(new CommandID(Common::CONNECT));
    }

    public static function rebootModule(): Command
    {
        return new Command(new CommandID(Common::REBOOT));
    }

    public static function getModuleUid(): Command
    {
        return new Command(new CommandID(Common::UID));
    }

    public static function getFirmware(): Command
    {
        return new Command(new CommandID(Common::FIRMWARE));
    }
}
