<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;

/** Instantiation via {@see self::fromArray()} after factory validation. */
final readonly class Input implements CommandData
{
    /**
     * @param int $inputNumber The digital input number of the module (0...N)
     * @param int $action Processing On = 1, processing Off = 0
     * @param int $antiBounce Anti-bounce delay (N * 20ms). Default N = 5 (100ms), max N = 255
     */
    private function __construct(
        public int $inputNumber,
        public int $action,
        public int $antiBounce,
    ) {
    }

    public static function fromArray(array $input): self
    {
        return new self(
            inputNumber: $input['inputNumber'],
            action: $input['action'],
            antiBounce: $input['antiBounce'],
        );
    }

    public function isEqual(CommandData $anotherCommandData): bool
    {
        return $this->toArray() === $anotherCommandData->toArray();
    }

    public function toArray(): array
    {
        return [
            CommandDataRootKey::Input->value => [
                'inputNumber' => $this->inputNumber,
                'action' => $this->action,
                'antiBounce' => $this->antiBounce,
            ],
        ];
    }

    public function toStream(): string
    {
        return chr($this->inputNumber) . chr($this->action) . chr($this->antiBounce);
    }

    public function toString(): string
    {
        return hexFormat($this->inputNumber)
            . hexFormat($this->action)
            . hexFormat($this->antiBounce);
    }
}
