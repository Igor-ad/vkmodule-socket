<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Controllers\ControllerMethodsResolver;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;
use Psr\Log\LoggerInterface;

abstract class BaseConsoleCommand implements ConsoleCommand
{
    use ControllerMethodsResolver;

    protected Request $request;
    protected RequestDto $requestDto;
    protected ?string $controllerMethod = null;

    public function __construct(protected string $service)
    {
    }

    public function execute(string $commandName, ?string $queryString = ''): int|string
    {
        return $this->handle($commandName, $queryString);
    }

    /**
     * @throws ModuleException
     */
    protected function controlClosure(?LoggerInterface $logger): \Closure
    {
        $this->controllerMethod = $this->controllerMethod ?? $this->resolve($this->requestDto->command->ID?->id);

        return function () use ($logger) {
            $transceiver = TransceiverFactory::transceiverInit($this->requestDto->connector);
            $service = new $this->service($transceiver);
            $service->setLogger($logger);

            return ControllerFactory::make($service, $this->requestDto->module->type);
        };
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function run(ControllerInterface $controller): string
    {
        $commandData = $this->requestDto->command->commandData;

        return $controller->{$this->controllerMethod}($commandData);
    }
}
