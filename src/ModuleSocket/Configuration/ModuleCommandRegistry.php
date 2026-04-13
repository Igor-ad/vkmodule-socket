<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Configuration;

use Autodoctor\ModuleSocket\Enums\ApiCommands;
use Autodoctor\ModuleSocket\Enums\CliCommands;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;

/**
 * Wire command ids, controller routing, domains (socket / card reader / unknown).
 * Input/relay index ranges per type: {@see ModuleHardwareCapabilities}.
 *
 * Data layout (on purpose not one giant table):
 * — merged {@see self::DEFINITIONS}: one row per wire id (controller, wire_domain, flags);
 * — {@see self::ALLOWED_IDS_BY_MODULE_TYPE}: which wire ids each hardware type may send;
 * — {@see self::resolveSurfaceNameToWireId()} (+ helpers): relay/input/type-dependent branches; {@see self::UNIVERSAL_SURFACE_TO_WIRE_ROWS} for commands whose wire id does not depend on module type;
 * — {@see self::surfaceCommandRequiresRelayDeviceNumber()} / {@see self::surfaceCommandRequiresInputDeviceNumber()}: which names carry relay/input indices in the request body.
 *
 * CLI/API logical name → wire id: {@see self::resolveSurfaceNameToWireId()}. {@see \Autodoctor\ModuleSocket\DTO\Request::resolveNameToCommandId()} delegates here.
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
    public const SOCKET = 'socket';

    public const CARD_READER = 'card_reader';

    public const UNKNOWN = 'unknown';

    /** Common + unknown sentinel (01–04, 0f). */
    private const COMMON = [
        Commands::CheckConnect->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'checkConnection',
        ],
        Commands::RebootController->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'rebootModule',
        ],
        Commands::GetFirmware->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getModuleFirmware',
        ],
        Commands::GetUid->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getModuleUID',
        ],
        Commands::UnknownCommand->value => [
            'wire_domain' => self::UNKNOWN,
        ],
    ];

    /** Socket-1 specific ids (30–32). */
    private const SOCKET_1 = [
        Commands::Socket1SetInput->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'inputSetup',
        ],
        Commands::Socket1GetInput->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getInput',
            'input_status_semantics' => true,
        ],
        Commands::GetAllInput->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getAllStatus',
        ],
    ];

    /** Socket-2 / 2W / 4 / 5 / Giant shared ids (20–25). */
    private const SOCKET_MULTI = [
        Commands::SetInput->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'inputSetup',
        ],
        Commands::GetInput->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getInput',
            'input_status_semantics' => true,
        ],
        Commands::RelayAction->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'relayAction',
        ],
        Commands::GetAllStatus->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getAllStatus',
        ],
        Commands::GetAnalogInput->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getAnalogInput',
        ],
        Commands::RelayGroupAction->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'relayGroupAction',
        ],
    ];

    /** Socket-3 specific ids (41–44). */
    private const SOCKET_3 = [
        Commands::GetTemperatureSensor0->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getSensor0',
        ],
        Commands::GetTemperatureSensor1->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getSensor1',
        ],
        Commands::Socket3RelayAction->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'relayAction',
        ],
        Commands::Socket3GetAllStatus->value => [
            'wire_domain' => self::SOCKET,
            'controller' => 'getAllStatus',
        ],
    ];

    /** Card reader wire ids. */
    private const CARDS = [
        Commands::EmMarineCard->value => [
            'wire_domain' => self::CARD_READER,
        ],
        Commands::MifareCard->value => [
            'wire_domain' => self::CARD_READER,
        ],
        Commands::ManagingOnlineStatus->value => [
            'wire_domain' => self::CARD_READER,
        ],
        Commands::ManagingOfflineStatus->value => [
            'wire_domain' => self::CARD_READER,
        ],
        Commands::ManagingResponseWaiting->value => [
            'wire_domain' => self::CARD_READER,
        ],
        Commands::ManagingResponseStatus->value => [
            'wire_domain' => self::CARD_READER,
        ],
    ];

    private const DEFINITIONS = self::COMMON
        + self::SOCKET_1
        + self::SOCKET_MULTI
        + self::SOCKET_3
        + self::CARDS;

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

    public static function controllerMethodForCommandId(string $commandId): ?string
    {
        $row = self::row($commandId);

        return $row['controller'] ?? null;
    }

    public static function isInputStatusCommandId(string $commandId): bool
    {
        $row = self::row($commandId);

        return $row !== null && ($row['input_status_semantics'] ?? false);
    }

    public static function wireDomainForCommandId(string $commandId): ?string
    {
        $row = self::row($commandId);

        return $row['wire_domain'] ?? null;
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

    /**
     * Pairs of CLI/API logical names for surface commands that carry a relay index in the body.
     * (Which wire id they map to is chosen elsewhere from {@see ModuleTypes}.)
     *
     * @var list<array{CliCommands, ApiCommands}>
     */
    private const RELAY_DEVICE_SURFACE_CLI_API_PAIRS = [
        [CliCommands::RelayControl, ApiCommands::ApiRelayControl],
        [CliCommands::RelayOn, ApiCommands::ApiRelayOn],
        [CliCommands::RelayOff, ApiCommands::ApiRelayOff],
    ];

    /**
     * Pairs of CLI/API logical names for surface commands that carry an input index in the body.
     *
     * @var list<array{CliCommands, ApiCommands}>
     */
    private const INPUT_DEVICE_SURFACE_CLI_API_PAIRS = [
        [CliCommands::InputSetup, ApiCommands::ApiInputSetup],
        [CliCommands::InputStatus, ApiCommands::ApiInputStatus],
    ];

    /**
     * Logical surface commands whose wire id is the same for every module type (no Socket-1 vs Socket-3 branching).
     * Each row: CLI name, API name, wire id — both surface names resolve to that single wire id.
     *
     * @var list<array{CliCommands, ApiCommands, Commands|Common}>
     */
    private const UNIVERSAL_SURFACE_TO_WIRE_ROWS = [
        [CliCommands::Connection, ApiCommands::ApiConnection, Common::Connect],
        [CliCommands::Firmware, ApiCommands::ApiFirmware, Common::Firmware],
        [CliCommands::Reboot, ApiCommands::ApiReboot, Common::Reboot],
        [CliCommands::Uid, ApiCommands::ApiUid, Common::Uid],
        [CliCommands::InputAnalog, ApiCommands::ApiInputAnalog, Commands::GetAnalogInput],
        [CliCommands::InputTemperature0, ApiCommands::ApiInputTemperature0, Commands::GetTemperatureSensor0],
        [CliCommands::InputTemperature1, ApiCommands::ApiInputTemperature1, Commands::GetTemperatureSensor1],
        [CliCommands::RelayGroupControl, ApiCommands::ApiRelayGroupControl, Commands::RelayGroupAction],
    ];

    public static function surfaceCommandRequiresRelayDeviceNumber(string $surfaceCommandName): bool
    {
        return in_array($surfaceCommandName, self::surfaceRelayCommandNames(), true);
    }

    public static function surfaceCommandRequiresInputDeviceNumber(string $surfaceCommandName): bool
    {
        return in_array($surfaceCommandName, self::surfaceInputCommandNames(), true);
    }

    public static function resolveSurfaceNameToWireId(string $surfaceCommandName, string $moduleType): ?string
    {
        if (in_array($surfaceCommandName, self::surfaceRelayCommandNames(), true)) {
            return self::relayActionWireIdForModuleType($moduleType);
        }
        if (in_array($surfaceCommandName, self::surfaceInputCommandNames(), true)) {
            return self::surfaceInputCommandToWireId($surfaceCommandName, $moduleType);
        }
        if (self::isSurfaceStatusCommand($surfaceCommandName)) {
            return self::allStatusWireIdForModuleType($moduleType);
        }

        return self::universalSurfaceNameToWireIdMap()[$surfaceCommandName] ?? null;
    }

    private static function surfaceRelayCommandNames(): array
    {
        static $names = null;

        return $names ??= self::surfaceStringsFromCliApiPairs(self::RELAY_DEVICE_SURFACE_CLI_API_PAIRS);
    }

    private static function surfaceInputCommandNames(): array
    {
        static $names = null;

        return $names ??= self::surfaceStringsFromCliApiPairs(self::INPUT_DEVICE_SURFACE_CLI_API_PAIRS);
    }

    /**
     * Expands each [CLI, API] pair into two string surface names (same order as declared).
     * @param list<array{CliCommands, ApiCommands}> $pairs
     */
    private static function surfaceStringsFromCliApiPairs(array $pairs): array
    {
        $out = [];
        foreach ($pairs as [$cli, $api]) {
            $out[] = $cli->value;
            $out[] = $api->value;
        }

        return $out;
    }

    /**
     * Lookup built from {@see self::UNIVERSAL_SURFACE_TO_WIRE_ROWS}: surface command string → wire id.
     */
    private static function universalSurfaceNameToWireIdMap(): array
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }
        $map = [];
        foreach (self::UNIVERSAL_SURFACE_TO_WIRE_ROWS as [$cli, $api, $wire]) {
            $id = $wire->value;
            $map[$cli->value] = $id;
            $map[$api->value] = $id;
        }

        return $map;
    }

    private static function surfaceStatusCommandNames(): array
    {
        static $names = null;

        return $names ??= self::surfaceStringsFromCliApiPairs([[CliCommands::Status, ApiCommands::ApiStatus]]);
    }

    private static function surfaceInputSetupCommandNames(): array
    {
        static $names = null;

        return $names ??= self::surfaceStringsFromCliApiPairs([[CliCommands::InputSetup, ApiCommands::ApiInputSetup]]);
    }

    private static function isSurfaceStatusCommand(string $surfaceCommandName): bool
    {
        return in_array($surfaceCommandName, self::surfaceStatusCommandNames(), true);
    }

    private static function surfaceInputCommandToWireId(string $surfaceCommandName, string $moduleType): string
    {
        $socket1 = $moduleType === ModuleTypes::Socket1->value;
        $isSetup = in_array($surfaceCommandName, self::surfaceInputSetupCommandNames(), true);

        return $isSetup
            ? ($socket1 ? Commands::Socket1SetInput->value : Commands::SetInput->value)
            : ($socket1 ? Commands::Socket1GetInput->value : Commands::GetInput->value);
    }

    private static function relayActionWireIdForModuleType(string $moduleType): string
    {
        return $moduleType === ModuleTypes::Socket3->value
            ? Commands::Socket3RelayAction->value
            : Commands::RelayAction->value;
    }

    private static function allStatusWireIdForModuleType(string $moduleType): string
    {
        return match ($moduleType) {
            ModuleTypes::Socket1->value => Commands::GetAllInput->value,
            ModuleTypes::Socket3->value => Commands::Socket3GetAllStatus->value,
            default => Commands::GetAllStatus->value,
        };
    }

    private static function row(string $commandId): ?array
    {
        return self::DEFINITIONS[$commandId] ?? null;
    }
}
