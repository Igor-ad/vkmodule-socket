<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\ControllerMethodsResolver;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\CliService;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;

class CliFullControl extends AbstractConsoleCommand
{
    use ControllerMethodsResolver;

    public string $name = 'cli_full_control';

    protected function controlClosure(?Logger $logger): \Closure
    {
        return function () use ($logger) {
            $this->controllerMethod = $this->resolve($this->requestDto->command->ID->id);

            $transceiver = TransceiverFactory::transceiverInit($this->requestDto->connector);
            $service = new CliService($transceiver);
            $service->setLogger($logger);

            return ControllerFactory::make($service, $this->requestDto->module->type);
        };
    }
}
