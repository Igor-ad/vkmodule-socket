<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

class RelayControlDataFactory extends AbstractCommandDataFactory
{
    /**
     * @throws InvalidInputParameterException
     */
    public function make(): ?CommandData
    {
        return new Relay(
            relayNumber: getValue($this->commandData, 'relay.relayNumber'),
            action: getValue($this->commandData, 'relay.action'),
            interval: getValue($this->commandData, 'relay.interval') ?? 0,
        );
    }
}
