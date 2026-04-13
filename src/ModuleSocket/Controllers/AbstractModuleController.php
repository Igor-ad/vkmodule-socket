<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;

abstract class AbstractModuleController extends CommonModuleController implements ControllerInterface
{
    public function getAllStatus(): string
    {
        return '';
    }

    public function getAnalogInput(): string
    {
        return '';
    }

    public function getInput(CommandData $commandData): string
    {
        return '';
    }

    public function getSensor0(): string
    {
        return '';
    }

    public function getSensor1(): string
    {
        return '';
    }

    public function inputSetup(CommandData $commandData): string
    {
        return '';
    }

    public function relayAction(CommandData $commandData): string
    {
        return '';
    }

    public function relayGroupAction(CommandData $commandData): string
    {
        return '';
    }
}
