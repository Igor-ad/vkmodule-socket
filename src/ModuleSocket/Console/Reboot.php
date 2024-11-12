<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Reboot extends AbstractConsoleCommand
{
    public string $name = 'reboot';
    protected string $controllerMethod = 'rebootModule';
}
