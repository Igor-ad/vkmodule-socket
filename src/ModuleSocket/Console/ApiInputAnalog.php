<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiInputAnalog extends AbstractApiCommand
{
    public string $name = 'api_input_analog';
    protected ?string $controllerMethod = 'getAnalogInput';
}
