<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
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

    /**
     * @throws ConfiguratorException
     * @throws InvalidInputParameterException
     * @throws InvalidRequestCommandException
     */
    public function handle(string $commandName, ?string $queryString): int|string
    {
        $this->requestDto = RequestDto::fromRequest(new Request($commandName, $queryString));
        $closure = $this->controlClosure(null);
        $controller = $closure();

        return $this->run($controller);
    }

    protected function loggerInit(): Logger
    {
        return new Logger(Files::ApiLogFile->getPath());
    }
}
