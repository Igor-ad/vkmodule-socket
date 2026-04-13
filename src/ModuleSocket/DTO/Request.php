<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProviderInterface;
use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Configuration\ModuleCommandRegistry;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\CommandFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\Validation\ValidatorInterface;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

readonly class Request
{
    public function __construct(
        public string $commandName,
        public array $request,
        private ConfigurationProviderInterface $configuration,
        private ValidatorInterface $validator,
    ) {
    }

    /** @throws ConfiguratorException */
    public static function fromInput(
        string $commandName,
        ?string $queryString,
        ?ConfigurationProviderInterface $configuration = null,
        ?ValidatorInterface $validator = null,
    ): self {
        $configuration ??= ConfigurationProvider::fromConfigFile(Files::ConfigFile->getPath());
        $validator ??= new Validator($configuration);

        return new self(
            commandName: $commandName,
            request: json_decode($queryString ?? '', true) ?? [],
            configuration: $configuration,
            validator: $validator,
        );
    }

    public function configuration(): ConfigurationProviderInterface
    {
        return $this->configuration;
    }

    public function validator(): ValidatorInterface
    {
        return $this->validator;
    }

    public function resolveNameToCommandId(string $moduleCommandName, string $moduleType): ?string
    {
        return ModuleCommandRegistry::resolveSurfaceNameToWireId($moduleCommandName, $moduleType);
    }

    /**
     * @throws InvalidRequestCommandException
     * @throws InvalidInputParameterException
     */
    public function makeCommand(string $moduleType, string $commandId, ?array $commandData): ?Command
    {
        $this->validator->validateModuleCommandId($commandId, $moduleType);

        return CommandFactory::make($commandId, $commandData, $this->validator);
    }

    /** @throws InvalidInputParameterException */
    public function makeModule(array $request): Module
    {
        return new Module(
            host: getValue($request, 'module.host'),
            port: getValue($request, 'module.port'),
            type: getValue($request, 'module.type'),
            configuration: $this->configuration,
            validator: $this->validator,
        );
    }
}
