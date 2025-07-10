<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiInputTemperature1 extends AbstractApiCommand
{
    public string $name = 'api_input_temperature1';
    protected ?string $controllerMethod = 'getSensor1';
}
