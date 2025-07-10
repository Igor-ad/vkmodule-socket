<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiInputTemperature0 extends AbstractApiCommand
{
    public string $name = 'api_input_temperature0';
    protected ?string $controllerMethod = 'getSensor0';
}
