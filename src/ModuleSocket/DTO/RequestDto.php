<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\ConnectorFactory;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Validator;
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
            'relay_on', 'api_relay_on' => self::setActionOn($commandData),
            'relay_off', 'api_relay_off' => self::setActionOff($commandData),

            default => $commandData,
        };
    }

    private static function setActionOn(array $commandData): array
    {
        $commandData['relay']['action'] = 1;

        return $commandData;
    }

    private static function setActionOff(array $commandData): array
    {
        $commandData['relay']['action'] = 0;

        return $commandData;
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected static function getValidInputNumber(Request $request, string $moduleType): int
    {
        $inputNumber = getValue($request->request, 'command.data.input.inputNumber');

        return Validator::instance()->validateInput($inputNumber, $moduleType);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    protected static function getValidRelayNumber(Request $request, string $moduleType): int
    {
        $relayNumber = getValue($request->request, 'command.data.relay.relayNumber');

        return Validator::instance()->validateRelay($relayNumber, $moduleType);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     */
    private static function validateModuleInternalDeviceNumber(Request $request, string $moduleType): void
    {
        match ($request->commandName) {
            'relay_control',
            'relay_on',
            'relay_off',
            'api_relay_control',
            'api_relay_on',
            'api_relay_off' => self::getValidRelayNumber($request, $moduleType),
            'input_setup',
            'input_status',
            'api_input_setup',
            'api_input_status' => self::getValidInputNumber($request, $moduleType),
            default => null,
        };
    }
}
