<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

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
 */
trait CommandIdResolver
{
    public function resolveNameToCommandId(string $moduleCommandName, string $moduleType): ?string
    {
        return match ($moduleCommandName) {
            'connection', 'api_connection' => Common::Connect->value,
            'firmware', 'api_firmware' => Common::Firmware->value,
            'reboot', 'api_reboot' => Common::Reboot->value,
            'uid', 'api_uid' => Common::Uid->value,
            'input_analog', 'api_input_analog' => Socket2::GetAnalogInput->value,
            'input_setup', 'api_input_setup' => $moduleType === ModuleTypes::Socket1->value
                ? Socket1::SetInput->value
                : Commands::SetInput->value,
            'input_status', 'api_input_status' => $moduleType === ModuleTypes::Socket1->value
                ? Socket1::GetInput->value
                : Commands::GetInput->value,
            'input_temperature0', 'api_input_temperature0' => Socket3::GetTemp0->value,
            'input_temperature1', 'api_input_temperature1' => Socket3::GetTemp1->value,
            'relay_control', 'api_relay_control', 'relay_off',
            'api_relay_off', 'relay_on', 'api_relay_on' => $this->relayControlResolveCommandId($moduleType),
            'relay_group_control', 'api_relay_group_control' => SocketGiant::RelayGroupAction->value,
            'status', 'api_status' => $this->getAllStatusResolveCommandId($moduleType),
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
