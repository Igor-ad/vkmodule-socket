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
    protected function resolve(string $commandId): string
    {
        return match ($commandId) {
            Commands::CHECK_CONNECT->value, => 'checkConnection',
            Commands::REBOOT_CONTROLLER->value => 'rebootModule',
            Commands::GET_FIRMWARE->value => 'getModuleFirmware',
            Commands::GET_UID->value => 'getModuleUID',
            Commands::SET_INPUT->value,
            Commands::SOCKET1_SET_INPUT->value => 'inputSetup',
            Commands::GET_INPUT->value,
            Commands::SOCKET1_GET_INPUT->value => 'getInput',
            Commands::RELAY_ACTION->value,
            Commands::SOCKET3_RELAY_ACTION->value => 'relayAction',
            Commands::GET_ALL_STATUS->value,
            Commands::GET_ALL_INPUT->value,
            Commands::SOCKET3_GET_ALL_STATUS->value => 'getAllStatus',
            Commands::GET_ANALOG_INPUT->value => 'getAnalogInput',
            Commands::GET_TEMPERATURE_SENSOR_0->value => 'getSensor0',
            Commands::GET_TEMPERATURE_SENSOR_1->value => 'getSensor1',
            Commands::RELAY_GROUP_ACTION->value => 'relayGroupAction',
            default => throw new ModuleException('Invalid module command ID.'),
        };
    }
}
