<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validator;

final readonly class Input implements CommandData
{
    /**
     * @param int $inputNumber The digital input number of the module (0...N)
     * @param int $action Processing On = 1, processing Off = 0
     * @param int $antiBounce Anti-bounce delay (N * 20ms). Default N = 5 (100ms), max N = 255
     *
     * @throws InvalidInputParameterException
     */
    public function __construct(
        public int $inputNumber,
        public int $action,
        public int $antiBounce
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidInputParameterException
     */
    private function validate(): void
    {
        Validator::instance()->validateInputAction($this->action);
        Validator::instance()->validateAntiBounce($this->antiBounce);
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
                'action' => $this->action,
                'antiBounce' => $this->antiBounce,
            ]
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
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
