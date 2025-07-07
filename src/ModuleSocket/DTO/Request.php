<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\CommandFactory;
use Autodoctor\ModuleSocket\Validator;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

readonly class Request
{
    use CommandIdResolver;

    public array $request;

    public function __construct(
        public string $commandName,
        ?string       $queryString,
    ) {
        $this->request = json_decode($queryString ?? '', true) ?? [];
    }

    /**
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     */
    public function makeCommand(string $moduleType, string $commandId, ?array $commandData): ?Command
    {
        Validator::instance()->validateModuleCommandId($commandId, $moduleType);

        return CommandFactory::make($commandId, $commandData);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function makeModule(array $request): Module
    {
        return new Module(
            getValue($request, 'module.host'),
            getValue($request, 'module.port'),
            getValue($request, 'module.type'),
        );
    }
}
