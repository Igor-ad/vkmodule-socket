<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories;

use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\AbstractCommandDataFactory;
use Autodoctor\ModuleSocket\Validation\ValidatorInterface;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;

class CommandFactory
{
    public static function make(string $commandId, ?array $commandData, ValidatorInterface $validator): Command
    {
        return new Command(
            new CommandID($commandId),
            AbstractCommandDataFactory::getDataFactory($commandData, $commandId, $validator)->make(),
        );
    }
}
