<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class InputTemperature1 extends AbstractConsoleCommand
{
    public string $name = 'input_temperature1';
    protected string $controllerMethod = 'getSensor1';
}
