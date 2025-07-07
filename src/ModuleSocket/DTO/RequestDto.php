<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\ConnectorFactory;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

readonly class RequestDto
{
    public function __construct(
        public ?Command  $command,
        public Connector $connector,
        public Module    $module,
    ) {
    }

    /**
     * @throws ConfiguratorException
     * @throws InvalidInputParameterException
     * @throws InvalidRequestCommandException
     */
    public static function fromRequest(Request $request): RequestDto
    {
        $module = $request->makeModule($request->request);
        $moduleCommandId = $request->resolveNameToCommandId($request->commandName, $module->type)
            ?? getValue($request->request, 'command.id');

        return new self(
            command: $request->makeCommand(
                $module->type,
                $moduleCommandId,
                getValue($request->request, 'command.data'),
            ),
            connector: ConnectorFactory::connectInit(
                $module->host,
                $module->port,
                getValue($request->request, 'connector.type'),
                getValue($request->request, 'connector.timeOut'),
            ),
            module: $module,
        );
    }
}
