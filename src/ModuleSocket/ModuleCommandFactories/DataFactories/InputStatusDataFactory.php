<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;

class InputStatusDataFactory extends InputSetupDataFactory
{
    public function make(): ?CommandData
    {
        return new InputStatus(
            inputNumber: getValue($this->commandData, 'input.inputNumber')
        );
    }
}
