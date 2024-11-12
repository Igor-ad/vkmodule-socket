<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiUid extends AbstractApiCommand
{
    public string $name = 'api_uid';
    protected string $controllerMethod = 'getModuleUID';
}
