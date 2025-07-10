<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Status extends AbstractConsoleCommand
{
    public string $name = 'status';
    protected ?string $controllerMethod = 'getAllStatus';
}
