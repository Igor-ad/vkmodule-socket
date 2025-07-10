<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus as CommandData;

/**
 * Example of a CLI query string for a single-module system:
 *      '{"command":{"data":{"input":{"inputNumber":0}}}}'
 * Or for a multi-module system:
 *      '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"},"command":{"data":{"input":{"inputNumber":0}}}}'
 */
class InputStatus extends AbstractConsoleCommand
{
    public string $name = 'input_status';
    protected ?string $controllerMethod = 'getInput';

    /**
     * @throws InvalidInputParameterException
     */
    protected function run(ControllerInterface $controller): string
    {
        $inputNumber = $this->getValidInputNumber();

        return $controller->getInput(commandData: new CommandData($inputNumber));
    }
}
