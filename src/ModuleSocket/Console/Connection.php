<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Connection extends AbstractConsoleCommand
{
    public string $name = 'connection';
    protected ?string $controllerMethod = 'checkConnection';
}
