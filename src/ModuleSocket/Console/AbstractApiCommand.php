<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\ApiService;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;

abstract class AbstractApiCommand extends AbstractConsoleCommand
{
    protected function controlClosure(?Logger $logger): \Closure
    {
        return function () {
            $transceiver = TransceiverFactory::transceiverInit($this->requestDto->connector);
            $service = new ApiService($transceiver);

            return ControllerFactory::make($service, $this->requestDto->module->type);
        };
    }

    public function handle(?string $queryString): int|string
    {
        try {
            $this->requestDto = new Request($queryString);

            $closure = $this->controlClosure(null);
            $controller = $closure();

            return $this->run($controller);
        } catch (\Exception $e) {

            return $e->getMessage();
        } catch (\Throwable $e) {

            return $e->getMessage();
        }
    }
}
