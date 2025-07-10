<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class ApiFirmware extends AbstractApiCommand
{
    public string $name = 'api_firmware';
    protected ?string $controllerMethod ='getModuleFirmware';
}
