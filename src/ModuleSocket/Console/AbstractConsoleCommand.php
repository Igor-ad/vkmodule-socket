<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Configurator;
use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\CliService;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\AbstractCommandDataFactory;
use Autodoctor\ModuleSocket\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

abstract class AbstractConsoleCommand implements ConsoleCommand
{
    public const START_MSG = 'Start';
    public const END_MSG = 'End';

    protected Request $requestDto;
    protected string $controllerMethod;

    public function execute(?string $queryString = ''): int|string
    {
        return $this->handle($queryString);
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

    public function handle(?string $queryString): int|string
    {
        $logger = $this->loggerInit();

        try {
            $this->requestDto = new Request($queryString);

            $logger->info(self::START_MSG);
            $logger->info($this->requestDto->module->toJson());

            $closure = $this->controlClosure($logger);
            $controller = $closure();
            $response = $this->run($controller);

            $logger->info('ResponseToJson: ' . $response);
            $logger->info(self::END_MSG);

            return 0;
        } catch (\Exception $e) {
            $logger->error(
                $this->messagePrefix($this->requestDto->module->type) . $e->getMessage(),
                $logger->getExceptionContext($e)
            );
            return 1;
        } catch (\Throwable $e) {
            $logger->critical($e->getMessage(), $logger->getExceptionContext($e));

            return 1;
        }
    }

    protected function loggerInit(): Logger
    {
        $logFile = dirname(__DIR__, 3) . Configurator::instance()->get('log_file');

        return new Logger($logFile);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function run(ControllerInterface $controller): string
    {
        $commandData = $this->getModuleCommandData();

        return $controller->{$this->controllerMethod}($commandData);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function getModuleCommandData(): ?CommandData
    {
        $commandData = AbstractCommandDataFactory::getDataFactory(
            getValue($this->requestDto->request, 'command.data'),
            getValue($this->requestDto->request, 'command.id')
        )->make();

        if (!is_null($commandData)) {
            if ($commandData::class === Relay::class) {
                $this->getValidRelayNumber();
            }

            if ($commandData::class === Input::class || $commandData::class === InputStatus::class) {
                $this->getValidInputNumber();
            }
        }
        return $commandData;
    }

    protected function messagePrefix(string $moduleType): string
    {
        return $moduleType . ' module exception. ';
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function getValidInputNumber(): int
    {
        $inputNumber = getValue($this->requestDto->request, 'command.data.input.inputNumber');

        return Validator::instance()->validateInput($inputNumber, $this->requestDto->module->type);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected function getValidRelayNumber(): int
    {
        $relayNumber = getValue($this->requestDto->request, 'command.data.relay.relayNumber');

        return Validator::instance()->validateRelay($relayNumber, $this->requestDto->module->type);
    }
}
