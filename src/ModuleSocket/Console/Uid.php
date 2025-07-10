<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Uid extends AbstractConsoleCommand
{
    public string $name = 'uid';
    protected ?string $controllerMethod = 'getModuleUID';
}
