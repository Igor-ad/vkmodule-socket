<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories;

use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\AbstractCommandDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;

class CommandFactory
{
    public function __construct(
        protected array $request
    ) {}

    public static function instance(array $request): static
    {
        return new static($request);
    }

    public function make(): Command
    {
        $commandId = getValue($this->request, 'command.id');
        return new Command(
            new CommandID($commandId),
            AbstractCommandDataFactory::getDataFactory($this->request, $commandId)->make(),
        );
    }
}
