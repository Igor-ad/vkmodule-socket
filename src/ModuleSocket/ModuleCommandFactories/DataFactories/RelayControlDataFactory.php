<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

class RelayControlDataFactory extends AbstractCommandDataFactory
{
    /** @throws InvalidInputParameterException */
    public function make(): ?CommandData
    {
        return Relay::fromArray($this->validatedRelayPayload());
    }

    /**
     * Relay index vs `module.type` is enforced in {@see \Autodoctor\ModuleSocket\DTO\RequestDto::getValidRelayNumber()}, not here:
     * {@see \Autodoctor\ModuleSocket\Validation\Validator::validateRelay()} without a module type uses the default config line.
     *
     * @throws InvalidInputParameterException
     */
    private function validatedRelayPayload(): array
    {
        $relayNumber = getValue($this->commandData, 'relay.relayNumber');
        $action = getValue($this->commandData, 'relay.action');
        $interval = getValue($this->commandData, 'relay.interval') ?? 0;

        $this->validator->validateRelayAction($action);
        $this->validator->validateInterval($interval);

        return [
            'relayNumber' => $relayNumber,
            'action' => $action,
            'interval' => $interval,
        ];
    }
}
