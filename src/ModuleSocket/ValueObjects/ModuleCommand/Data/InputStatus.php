<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

final readonly class InputStatus implements CommandData
{
    /**
     * @param int $inputNumber The digital input number of the module (0...N)
     */
    public function __construct(
        public int $inputNumber,
    ) {
    }

    public function isEqual(CommandData $anotherCommandData): bool
    {
        return $this->toArray() === $anotherCommandData->toArray();
    }

    public function toArray(): array
    {
        return [
            'input' => [
                'inputNumber' => $this->inputNumber,
            ]
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toStream(): string
    {
        return chr($this->inputNumber);
    }

    public function toString(): string
    {
        return hexFormat($this->inputNumber);
    }
}
