<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\ConnectorFactory;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\CommandFactory;
use Autodoctor\ModuleSocket\Validator;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

final class Request
{
    public ?Command $command;
    public Connector $connector;
    public Module $module;
    public array $request = [];

    /**
     * @throws ConfiguratorException
     * @throws InvalidInputParameterException
     * @throws InvalidRequestCommandException
     */
    public function __construct(
        ?string $queryString,
    ) {
        $this->request = json_decode($queryString ?? '', true) ?? [];
        $this->module = $this->module($this->request);
        $this->connector = $this->connector($this->module->host, $this->module->port, $this->request);
        $this->command = $this->command($this->module->type, $this->request);
    }

    /**
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     */
    public function command(string $moduleType, array $request): ?Command
    {
        $commandId = getValue($request, 'command.id');

        if (is_null($commandId)) {
            return null;
        }
        Validator::instance()->validateModuleCommandId($commandId, $moduleType);
        $commandFactory = CommandFactory::instance($request);

        return $commandFactory->make();
    }

    public function connector(string $host, int $port, array $request): Connector
    {
        return ConnectorFactory::connectInit(
            $host,
            $port,
            getValue($request, 'connector.type'),
            getValue($request, 'connector.timeOut'),
        );
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function module(array $request): Module
    {
        return new Module(
            getValue($request, 'module.host'),
            getValue($request, 'module.port'),
            getValue($request, 'module.type'),
        );
    }
}
