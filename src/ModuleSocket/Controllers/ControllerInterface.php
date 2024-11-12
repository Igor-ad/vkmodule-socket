<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;

interface ControllerInterface
{
    public function checkConnection(): string;

    public function getAllStatus(): string;

    public function getAnalogInput(): string;

    public function getInput(CommandData $commandData): string;

    public function getModuleFirmware(): string;

    public function getModuleUID(): string;

    public function getSensor0(): string;

    public function getSensor1(): string;

    public function inputSetup(CommandData $commandData): string;

    public function rebootModule(): string;

    public function relayAction(CommandData $commandData): string;

    public function relayGroupAction(CommandData $commandData): string;
}
