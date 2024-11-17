<?php

declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputSetupDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use PHPUnit\Framework\TestCase;

class InputSetupDataFactoryTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testMake(): void
    {
        $commandData = [
            'input' => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ],
        ];
        $factory = new InputSetupDataFactory($commandData);
        $data = $factory->make();
        $this->assertTrue(is_a($data, Input::class));
        $this->assertSame(expected: $commandData, actual: $data->toArray());
    }
}
