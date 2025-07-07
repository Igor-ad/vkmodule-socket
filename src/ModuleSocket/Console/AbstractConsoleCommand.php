<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\DTO\CommandIdResolver;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\CliService;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;
use Autodoctor\ModuleSocket\Validator;

abstract class AbstractConsoleCommand implements ConsoleCommand
{
    public const START_MSG = 'Start';
    public const END_MSG = 'End';

    protected Request $request;
    protected RequestDto $requestDto;
    protected string $controllerMethod;

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     */
    public function execute(string $commandName, ?string $queryString = ''): void
    {
        $this->handle($commandName, $queryString);
    }

    protected function controlClosure(?Logger $logger): \Closure
    {
        return function () use ($logger) {
            $transceiver = TransceiverFactory::transceiverInit($this->requestDto->connector);
            $service = new CliService($transceiver);
            $service->setLogger($logger);

            return ControllerFactory::make($service, $this->requestDto->module->type);
        };
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     */
    public function handle(string $commandName, ?string $queryString): mixed
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

        exit(0);
    }

    protected function loggerInit(): Logger
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
