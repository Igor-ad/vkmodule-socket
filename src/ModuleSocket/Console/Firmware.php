<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Firmware extends AbstractConsoleCommand
{
    public string $name = 'firmware';
    protected string $controllerMethod = 'getModuleFirmware';
}
