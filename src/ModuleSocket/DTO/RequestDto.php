<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Configuration\ModuleCommandRegistry;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\ConnectorFactory;
use Autodoctor\ModuleSocket\Enums\ApiCommands;
use Autodoctor\ModuleSocket\Enums\CliCommands;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

readonly class RequestDto
{
    public function __construct(
        public ?Command $command,
        public Connector $connector,
        public Module $module,
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
        self::validateModuleInternalDeviceNumber($request, $module->type);

        return new self(
            command: $request->makeCommand(
                $module->type,
                $moduleCommandId,
                self::getCommandData($request),
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

    private static function getCommandData(Request $request): ?array
    {
        $commandData = getValue($request->request, 'command.data');

        return match ($request->commandName) {
            CliCommands::RelayOn->value,
            ApiCommands::ApiRelayOn->value => self::setActionOn($commandData),
            CliCommands::RelayOff->value,
            ApiCommands::ApiRelayOff->value => self::setActionOff($commandData),
            default => $commandData,
        };
    }

    private static function setActionOn(array $commandData): array
    {
        $commandData[CommandDataRootKey::Relay->value]['action'] = 1;

        return $commandData;
    }

    private static function setActionOff(array $commandData): array
    {
        $commandData[CommandDataRootKey::Relay->value]['action'] = 0;

        return $commandData;
    }

    /** @throws InvalidInputParameterException */
    protected static function getValidInputNumber(Request $request, string $moduleType): int
    {
        $inputNumber = getValue($request->request, 'command.data.' . CommandDataRootKey::Input->value . '.inputNumber');

        return $request->validator()->validateInput($inputNumber, $moduleType);
    }

    /** @throws InvalidInputParameterException */
    protected static function getValidRelayNumber(Request $request, string $moduleType): int
    {
        $relayNumber = getValue($request->request, 'command.data.' . CommandDataRootKey::Relay->value . '.relayNumber');

        return $request->validator()->validateRelay($relayNumber, $moduleType);
    }

    /** @throws InvalidInputParameterException */
    private static function validateModuleInternalDeviceNumber(Request $request, string $moduleType): void
    {
        if (ModuleCommandRegistry::surfaceCommandRequiresRelayDeviceNumber($request->commandName)) {
            self::getValidRelayNumber($request, $moduleType);

            return;
        }
        if (ModuleCommandRegistry::surfaceCommandRequiresInputDeviceNumber($request->commandName)) {
            self::getValidInputNumber($request, $moduleType);
        }
    }
}
