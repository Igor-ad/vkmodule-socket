<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiConnection extends AbstractApiCommand
{
    public string $name = 'api_connection';
    protected ?string $controllerMethod ='checkConnection';
}
