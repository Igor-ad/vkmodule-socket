<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

/**
 * Example of a CLI query string for a single-module system:
 *      '{"command":{"data":{"input":{"inputNumber":0,"action":0,"antiBounce":5}}}}'
 * Or for a multi-module system:
 *      '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"},"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}}}'
 */
class InputSetup extends AbstractConsoleCommand
{
    public string $name = 'input_setup';
    protected ?string $controllerMethod = 'inputSetup';
}
