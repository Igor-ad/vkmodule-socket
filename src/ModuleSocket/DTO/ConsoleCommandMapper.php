<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Enums\ApiCommands;
use Autodoctor\ModuleSocket\Enums\CliCommands;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use Autodoctor\ModuleSocket\Enums\Socket1;
use Autodoctor\ModuleSocket\Enums\Socket2;
use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\Enums\SocketGiant;

/**
 * name of command      |  modules types support    |  description
 * _____________________|___________________________|_____________________________________
 * connection           | for all types of modules  | check connection
 * firmware             | for all types of modules  | get firmware of module
 * reboot               | for all types of modules  | reboot module
 * uid                  | for all types of modules  | get uid of module
 * cli_full_control **  | for all types of modules  | any command by ID
 * input_analog         | Socket-2W only            | analog input voltage value
 * input_setup *        | Socket-(1,2,5,Giant)      | configure digital input
 * input_status *       | Socket-(1,2,5,Giant)      | digital input status
 * input_temperature0   | Socket-3 only             | sensor 0 temperature value
 * input_temperature1   | Socket-3 only             | sensor 1 temperature value
 * relay_control *      | Socket-(2,3,4,5,Giant)    | relay control
 * relay_group_control *| Socket-Giant only         | control all module relays
 * relay_off *          | Socket-(2,3,4,5,Giant)    | turn off relay
 * relay_on *           | Socket-(2,3,4,5,Giant)    | turn on relay
 * status               | for all types of modules  | get the state of all inputs/outputs
 * api_full_control     | for all types of modules  | any module command by ID
 */
trait ConsoleCommandMapper
{
    public function resolveNameToCommandId(string $moduleCommandName, string $moduleType): ?string
    {
        return match ($moduleCommandName) {
            CliCommands::Connection->value,
            ApiCommands::ApiConnection->value => Common::Connect->value,
            CliCommands::Firmware->value,
            ApiCommands::ApiFirmware->value => Common::Firmware->value,
            CliCommands::Reboot->value,
            ApiCommands::ApiReboot->value => Common::Reboot->value,
            CliCommands::Uid->value,
            ApiCommands::ApiUid->value => Common::Uid->value,
            CliCommands::InputAnalog->value,
            ApiCommands::ApiInputAnalog->value => Socket2::GetAnalogInput->value,
            CliCommands::InputSetup->value,
            ApiCommands::ApiInputSetup->value => $moduleType === ModuleTypes::Socket1->value
                ? Socket1::SetInput->value
                : Commands::SetInput->value,
            CliCommands::InputStatus->value,
            ApiCommands::ApiInputStatus->value => $moduleType === ModuleTypes::Socket1->value
                ? Socket1::GetInput->value
                : Commands::GetInput->value,
            CliCommands::InputTemperature0->value,
            ApiCommands::ApiInputTemperature0->value => Socket3::GetTemp0->value,
            CliCommands::InputTemperature1->value,
            ApiCommands::ApiInputTemperature1->value => Socket3::GetTemp1->value,
            CliCommands::RelayControl->value,
            CliCommands::RelayOff->value,
            CliCommands::RelayOn->value,
            ApiCommands::ApiRelayControl->value,
            ApiCommands::ApiRelayOff->value,
            ApiCommands::ApiRelayOn->value => $this->relayControlResolveCommandId($moduleType),
            CliCommands::RelayGroupControl->value,
            ApiCommands::ApiRelayGroupControl->value => SocketGiant::RelayGroupAction->value,
            CliCommands::Status->value,
            ApiCommands::ApiStatus->value => $this->getAllStatusResolveCommandId($moduleType),
            default => null,
        };
    }

    private function relayControlResolveCommandId(string $moduleType): string
    {
        return $moduleType === ModuleTypes::Socket3->value
            ? Socket3::RelayAction->value
            : Commands::RelayAction->value;
    }

    private function getAllStatusResolveCommandId(string $moduleType): string
    {
        return match ($moduleType) {
            ModuleTypes::Socket1->value => Socket1::GetAllInput->value,
            ModuleTypes::Socket3->value => Socket3::GetAllStatus->value,
            default => Commands::GetAllStatus->value,
        };
    }
}
