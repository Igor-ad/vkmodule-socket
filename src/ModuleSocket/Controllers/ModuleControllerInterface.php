<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;

interface ModuleControllerInterface
{
    public function getAllStatus(): string;

    public function getAnalogInput(): string;

    public function getInput(CommandData $commandData): string;

    public function getSensor0(): string;

    public function getSensor1(): string;

    public function inputSetup(CommandData $commandData): string;

    public function relayAction(CommandData $commandData): string;

    public function relayGroupAction(CommandData $commandData): string;
}
