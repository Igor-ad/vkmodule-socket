<?php

declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputStatusDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use PHPUnit\Framework\TestCase;

class InputStatusDataFactoryTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testMake(): void
    {
        $commandData = [
            'input' => [
                'inputNumber' => 0,
            ]
        ];
        $factory = new InputStatusDataFactory($commandData);
        $data = $factory->make();
        $this->assertInstanceOf(InputStatus::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());
    }
}
