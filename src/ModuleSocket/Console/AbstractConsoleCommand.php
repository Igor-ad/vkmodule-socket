<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Controllers\ControllerMethodsResolver;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\CliService;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;
use Autodoctor\ModuleSocket\Validator;
use Psr\Log\LoggerInterface;

abstract class AbstractConsoleCommand implements ConsoleCommand
{
    use ControllerMethodsResolver;

    public const START_MSG = 'Start';
    public const END_MSG = 'End';

    protected Request $request;
    protected RequestDto $requestDto;
    protected ?string $controllerMethod = null;
    protected string $service = CliService::class;

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     * @throws ModuleException
     */
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
     * @throws InvalidRequestCommandException
     * @throws ModuleException
     */
    public function handle(string $commandName, ?string $queryString): int|string
    {
        $logger = $this->loggerInit();
        $this->request = new Request($commandName, $queryString);
        $this->requestDto = RequestDto::fromRequest($this->request);

        $logger->info(self::START_MSG);
        $logger->info($this->requestDto->module->toJson());

        $closure = $this->controlClosure($logger);
        $controller = $closure();
        $response = $this->run($controller);

        $logger->info('ResponseToJson: ' . $response);
        $logger->info(self::END_MSG);

        return 0;
    }

    protected function loggerInit(): LoggerInterface
    {
        return new Logger(Files::CliLogFile->getPath());
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

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function getValidInputNumber(): int
    {
        $inputNumber = getValue($this->requestDto->command->commandData->toArray(), 'input.inputNumber');

        return Validator::instance()->validateInput($inputNumber, $this->requestDto->module->type);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function getValidRelayNumber(): int
    {
        $relayNumber = getValue($this->requestDto->command->commandData->toArray(), 'relay.relayNumber');

        return Validator::instance()->validateRelay($relayNumber, $this->requestDto->module->type);
    }
}
