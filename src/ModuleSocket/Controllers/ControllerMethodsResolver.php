<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;

trait ControllerMethodsResolver
{
    /**
     * @throws ModuleException
     */
    protected function resolve(?string $commandId): string
    {
        return match ($commandId) {
            Commands::CheckConnect->value, => 'checkConnection',
            Commands::RebootController->value => 'rebootModule',
            Commands::GetFirmware->value => 'getModuleFirmware',
            Commands::GetUid->value => 'getModuleUID',
            Commands::SetInput->value,
            Commands::Socket1SetInput->value => 'inputSetup',
            Commands::GetInput->value,
            Commands::Socket1GetInput->value => 'getInput',
            Commands::RelayAction->value,
            Commands::Socket3RelayAction->value => 'relayAction',
            Commands::GetAllStatus->value,
            Commands::GetAllInput->value,
            Commands::Socket3GetAllStatus->value => 'getAllStatus',
            Commands::GetAnalogInput->value => 'getAnalogInput',
            Commands::GetTemperatureSensor0->value => 'getSensor0',
            Commands::GetTemperatureSensor1->value => 'getSensor1',
            Commands::RelayGroupAction->value => 'relayGroupAction',
            default => throw new ModuleException('Invalid module command ID.'),
        };
    }
}
