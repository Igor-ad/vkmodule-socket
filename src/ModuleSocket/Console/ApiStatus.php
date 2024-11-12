<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiStatus extends AbstractApiCommand
{
    public string $name = 'api_status';
    protected string $controllerMethod = 'getAllStatus';
}
