<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiReboot extends AbstractApiCommand
{
    public string $name = 'api_reboot';
    protected string $controllerMethod = 'rebootModule';
}
