<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\ControllerMethodsResolver;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\ApiService;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;

class ApiFullControl extends AbstractApiCommand
{
    use ControllerMethodsResolver;

    public string $name = 'api_full_control';

    protected function controlClosure(?Logger $logger): \Closure
    {
        return function () {
            $this->controllerMethod = $this->resolve($this->requestDto->command->ID->id);

            $transceiver = TransceiverFactory::transceiverInit($this->requestDto->connector);
            $service = new ApiService($transceiver);

            return ControllerFactory::make($service, $this->requestDto->module->type);
        };
    }
}
