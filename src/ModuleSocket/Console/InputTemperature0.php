<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class InputTemperature0 extends AbstractConsoleCommand
{
    public string $name = 'input_temperature0';
    protected ?string $controllerMethod = 'getSensor0';
}
