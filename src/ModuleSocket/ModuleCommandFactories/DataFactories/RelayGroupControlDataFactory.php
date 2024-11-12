<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;

class RelayGroupControlDataFactory extends AbstractCommandDataFactory
{
    /**
     * @throws InvalidInputParameterException
     */
    public function make(): ?CommandData
    {
        return new RelayGroup(
            getValue($this->commandData, 'relayGroup.relayGroupAction')
        );
    }
}
