<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;

class InputSetupDataFactory extends AbstractCommandDataFactory
{
    /**
     * @throws InvalidInputParameterException
     */
    public function make(): ?CommandData
    {
        return Input::fromArray($this->validatedInputSetupPayload());
    }

    /**
     * @throws InvalidInputParameterException
     */
    private function validatedInputSetupPayload(): array
    {
        $inputNumber = getValue($this->commandData, 'input.inputNumber');
        $action = getValue($this->commandData, 'input.action');
        $antiBounce = getValue($this->commandData, 'input.antiBounce');

        $this->validator->validateInputAction($action);
        $this->validator->validateAntiBounce($antiBounce);

        return [
            'inputNumber' => $inputNumber,
            'action' => $action,
            'antiBounce' => $antiBounce,
        ];
    }
}
