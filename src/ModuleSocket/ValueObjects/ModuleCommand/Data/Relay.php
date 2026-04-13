<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;

/** Instantiation via {@see self::fromArray()} after factory validation. */
final readonly class Relay implements CommandData
{
    /**
     * @param int $relayNumber The relay number in the module (0...N)
     * @param int $action Turns On the relay (1). Turns Off the relay (0)
     * @param int $interval Enable duration (1-255 * 100ms). 0 - The relay is always On
     */
    private function __construct(
        public int $relayNumber,
        public int $action,
        public int $interval = 0,
    ) {
    }

    public static function fromArray(array $relay): self
    {
        return new self(
            relayNumber: $relay['relayNumber'],
            action: $relay['action'],
            interval: $relay['interval'] ?? 0,
        );
    }

    public function isEqual(CommandData $anotherCommandData): bool
    {
        return $this->toArray() === $anotherCommandData->toArray();
    }

    public function toArray(): array
    {
        return [
            CommandDataRootKey::Relay->value => [
                'relayNumber' => $this->relayNumber,
                'action' => $this->action,
                'interval' => $this->interval,
            ],
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
