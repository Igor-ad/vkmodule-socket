<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Services\ApiService;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractApiCommand extends AbstractConsoleCommand
{
    protected string $service = ApiService::class;

    /**
     * @throws ConfiguratorException
     * @throws InvalidInputParameterException
     * @throws ModuleException
     * @throws InvalidRequestCommandException
     */
    public function handle(string $commandName, ?string $queryString): int|string
    {
        $logger = $this->loggerInit();
        $this->requestDto = RequestDto::fromRequest(new Request($commandName, $queryString));
        $closure = $this->controlClosure($logger);
        $controller = $closure();

        return $this->run($controller);
    }

    protected function loggerInit(): LoggerInterface
    {
        return new NullLogger();
    }
}
