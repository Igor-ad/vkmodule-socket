<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Configuration;

use Autodoctor\ModuleSocket\Enums\CliCommands;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;

/**
 * Wire command ids, controller routing, command names resolution.
 * Input/relay index ranges per type: {@see ModuleHardwareCapabilities}.
 *
 * Data layout:
 * — {@see self::CONTROLLER_METHOD_BY_ID}: wire id => controller method (ids without a method are not routed);
 * — {@see self::INPUT_STATUS_IDS}: wire ids of digital input reads (their response is compared by the first byte);
 * — {@see self::ALLOWED_IDS_BY_MODULE_TYPE}: which wire ids each hardware type may send;
 * — {@see self::resolveSurfaceNameToWireId()}: logical name => wire id, which may depend on the module type;
 *   the `api_` prefix of a name is an alias and is ignored, so `api_relay_on` and `relay_on` are the same command;
 * — {@see self::surfaceCommandRequiresRelayDeviceNumber()} / {@see self::surfaceCommandRequiresInputDeviceNumber()}:
 *   which names carry relay/input indices in the request body.
 *
 * CLI/API logical name → wire id: {@see self::resolveSurfaceNameToWireId()}.
 * {@see \Autodoctor\ModuleSocket\DTO\Request::resolveNameToCommandId()} delegates here.
 *
 * Human-oriented overview (logical name / module support / meaning):
 *
 * ```
 * name of command       |  modules types support     |  description
 * ______________________|____________________________|_____________________________________
 * connection            | for all types of modules   | check connection
 * firmware              | for all types of modules   | get firmware of module
 * reboot                | for all types of modules   | reboot module
 * uid                   | for all types of modules   | get uid of module
 * cli_full_control **   | for all types of modules   | any command by ID
 * input_analog          | Socket-2W only             | analog input voltage value
 * input_setup *         | Socket-(1,2,5,Giant)       | configure digital input
 * input_status *        | Socket-(1,2,5,Giant)       | digital input status
 * input_temperature0    | Socket-3 only              | sensor 0 temperature value
 * input_temperature1    | Socket-3 only              | sensor 1 temperature value
 * relay_control *       | Socket-(2,3,4,5,Giant)     | relay control
 * relay_group_control * | Socket-Giant only          | control all module relays
 * relay_off *           | Socket-(2,3,4,5,Giant)     | turn off relay
 * relay_on *            | Socket-(2,3,4,5,Giant)     | turn on relay
 * status                | for all types of modules   | get the state of all inputs/outputs
 * api_full_control      | for all types of modules   | any module command by ID
 * ```
 */
final class ModuleCommandRegistry
{
    /** Alias prefix of the logical command names: 'api_relay_on' is the same command as 'relay_on'. */
    private const API_PREFIX = 'api_';

    private const CONTROLLER_METHOD_BY_ID = [
        Commands::CheckConnect->value => 'checkConnection',
        Commands::RebootController->value => 'rebootModule',
        Commands::GetFirmware->value => 'getModuleFirmware',
        Commands::GetUid->value => 'getModuleUID',
        Commands::Socket1SetInput->value => 'inputSetup',
        Commands::Socket1GetInput->value => 'getInput',
        Commands::GetAllInput->value => 'getAllStatus',
        Commands::SetInput->value => 'inputSetup',
        Commands::GetInput->value => 'getInput',
        Commands::RelayAction->value => 'relayAction',
        Commands::GetAllStatus->value => 'getAllStatus',
        Commands::GetAnalogInput->value => 'getAnalogInput',
        Commands::RelayGroupAction->value => 'relayGroupAction',
        Commands::GetTemperatureSensor0->value => 'getSensor0',
        Commands::GetTemperatureSensor1->value => 'getSensor1',
        Commands::Socket3RelayAction->value => 'relayAction',
        Commands::Socket3GetAllStatus->value => 'getAllStatus',
    ];

    private const INPUT_STATUS_IDS = [
        Commands::Socket1GetInput->value,
        Commands::GetInput->value,
    ];

    private const OUTBOUND_COMMON_IDS = [
        Commands::CheckConnect->value,
        Commands::RebootController->value,
        Commands::GetFirmware->value,
        Commands::GetUid->value,
    ];

    /** Outbound wire ids allowed per hardware type ({@see ModuleTypes} `value` => list). */
    private const ALLOWED_IDS_BY_MODULE_TYPE = [
        ModuleTypes::Socket1->value => [
            ...self::OUTBOUND_COMMON_IDS,
            Commands::Socket1SetInput->value,
            Commands::Socket1GetInput->value,
            Commands::GetAllInput->value,
        ],
        ModuleTypes::Socket2->value => [
            ...self::OUTBOUND_COMMON_IDS,
            Commands::SetInput->value,
            Commands::GetInput->value,
            Commands::RelayAction->value,
            Commands::GetAllStatus->value,
            Commands::GetAnalogInput->value,
        ],
        ModuleTypes::Socket3->value => [
            ...self::OUTBOUND_COMMON_IDS,
            Commands::GetTemperatureSensor0->value,
            Commands::GetTemperatureSensor1->value,
            Commands::Socket3RelayAction->value,
            Commands::Socket3GetAllStatus->value,
        ],
        ModuleTypes::Socket4->value => [
            ...self::OUTBOUND_COMMON_IDS,
            Commands::RelayAction->value,
            Commands::GetAllStatus->value,
        ],
        ModuleTypes::Socket5->value => [
            ...self::OUTBOUND_COMMON_IDS,
            Commands::SetInput->value,
            Commands::GetInput->value,
            Commands::RelayAction->value,
            Commands::GetAllStatus->value,
        ],
        ModuleTypes::SocketGiant->value => [
            ...self::OUTBOUND_COMMON_IDS,
            Commands::SetInput->value,
            Commands::GetInput->value,
            Commands::RelayAction->value,
            Commands::GetAllStatus->value,
            Commands::RelayGroupAction->value,
        ],
    ];

    /** Logical names that carry a relay index in the request body. */
    private const RELAY_COMMAND_NAMES = [
        CliCommands::RelayControl->value,
        CliCommands::RelayOn->value,
        CliCommands::RelayOff->value,
    ];

    /** Logical names that carry an input index in the request body. */
    private const INPUT_COMMAND_NAMES = [
        CliCommands::InputSetup->value,
        CliCommands::InputStatus->value,
    ];

    /** Logical names whose wire id does not depend on the module type. */
    private const UNIVERSAL_COMMAND_IDS = [
        CliCommands::Connection->value => Common::Connect->value,
        CliCommands::Firmware->value => Common::Firmware->value,
        CliCommands::Reboot->value => Common::Reboot->value,
        CliCommands::Uid->value => Common::Uid->value,
        CliCommands::InputAnalog->value => Commands::GetAnalogInput->value,
        CliCommands::InputTemperature0->value => Commands::GetTemperatureSensor0->value,
        CliCommands::InputTemperature1->value => Commands::GetTemperatureSensor1->value,
        CliCommands::RelayGroupControl->value => Commands::RelayGroupAction->value,
    ];

    public static function controllerMethodForCommandId(string $commandId): ?string
    {
        return self::CONTROLLER_METHOD_BY_ID[$commandId] ?? null;
    }

    public static function isInputStatusCommandId(string $commandId): bool
    {
        return in_array($commandId, self::INPUT_STATUS_IDS, true);
    }

    public static function allowedCommandIdsForModuleType(string $moduleType): array
    {
        return self::ALLOWED_IDS_BY_MODULE_TYPE[$moduleType] ?? [];
    }

    public static function isWireCommandAllowedForModuleType(string $commandId, string $moduleType): bool
    {
        return in_array($commandId, self::allowedCommandIdsForModuleType($moduleType), true);
    }

    public static function isWireSetInputCommandId(string $commandId): bool
    {
        return $commandId === Commands::Socket1SetInput->value
            || $commandId === Commands::SetInput->value;
    }

    public static function surfaceCommandRequiresRelayDeviceNumber(string $surfaceCommandName): bool
    {
        return in_array(self::logicalName($surfaceCommandName), self::RELAY_COMMAND_NAMES, true);
    }

    public static function surfaceCommandRequiresInputDeviceNumber(string $surfaceCommandName): bool
    {
        return in_array(self::logicalName($surfaceCommandName), self::INPUT_COMMAND_NAMES, true);
    }

    public static function resolveSurfaceNameToWireId(string $surfaceCommandName, string $moduleType): ?string
    {
        $name = self::logicalName($surfaceCommandName);
        $isSocket1 = $moduleType === ModuleTypes::Socket1->value;

        return match (true) {
            in_array($name, self::RELAY_COMMAND_NAMES, true) => $moduleType === ModuleTypes::Socket3->value
                ? Commands::Socket3RelayAction->value
                : Commands::RelayAction->value,
            $name === CliCommands::InputSetup->value => $isSocket1
                ? Commands::Socket1SetInput->value
                : Commands::SetInput->value,
            $name === CliCommands::InputStatus->value => $isSocket1
                ? Commands::Socket1GetInput->value
                : Commands::GetInput->value,
            $name === CliCommands::Status->value => match ($moduleType) {
                ModuleTypes::Socket1->value => Commands::GetAllInput->value,
                ModuleTypes::Socket3->value => Commands::Socket3GetAllStatus->value,
                default => Commands::GetAllStatus->value,
            },
            default => self::UNIVERSAL_COMMAND_IDS[$name] ?? null,
        };
    }

    /** Command name without the 'api_' alias prefix. */
    public static function logicalName(string $surfaceCommandName): string
    {
        return str_starts_with($surfaceCommandName, self::API_PREFIX)
            ? substr($surfaceCommandName, strlen(self::API_PREFIX))
            : $surfaceCommandName;
    }
}
