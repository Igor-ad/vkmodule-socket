<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Logger\Logger;
use Psr\Log\LoggerInterface;

class CliConsoleCommand extends BaseConsoleCommand
{
    public const START_MSG = 'Start';
    public const END_MSG = 'End';

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     * @throws ModuleException
     */
    public function handle(string $commandName, ?string $queryString): int
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
}
