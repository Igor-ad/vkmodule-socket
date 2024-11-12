<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class InputAnalog extends AbstractConsoleCommand
{
    public string $name = 'input_analog';
    protected string $controllerMethod = 'getAnalogInput';
}
