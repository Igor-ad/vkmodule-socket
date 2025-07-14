<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validator;

final readonly class Relay implements CommandData
{
    /**
     * @param int $relayNumber The relay number in the module (0...N)
     * @param int $action Turns On the relay (1). Turns Off the relay (0)
     * @param int $interval Enable duration (1-255 * 100ms). 0 - The relay is always On
     *
     * @throws InvalidInputParameterException
     */
    public function __construct(
        public int $relayNumber,
        public int $action,
        public int $interval = 0
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidInputParameterException
     */
    private function validate(): void
    {
        Validator::instance()->validateRelayAction($this->action);
        Validator::instance()->validateInterval($this->interval);
    }

    public function isEqual(CommandData $anotherCommandData): bool
    {
        return $this->toArray() === $anotherCommandData->toArray();
    }

    public function toArray(): array
    {
        return [
            'relay' => [
                'relayNumber' => $this->relayNumber,
                'action' => $this->action,
                'interval' => $this->interval,
            ]
        ];
    }

    public function toStream(): string
    {
        return chr($this->relayNumber) . chr($this->action) . chr($this->interval);
    }

    public function toString(): string
    {
        return hexFormat($this->relayNumber)
            . hexFormat($this->action)
            . hexFormat($this->interval);
    }
}
