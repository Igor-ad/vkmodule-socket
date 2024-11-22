<?php declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputSetupDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InputSetupDataFactory::class)]
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

        $this->assertInstanceOf(Input::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());

        $commandData = [
            'input' => [
                'inputNumber' => 0,
                'action' => 10,
                'antiBounce' => 5000,
            ],
        ];
        $factory = new InputSetupDataFactory($commandData);

        $this->expectException(InvalidInputParameterException::class);
        $factory->make();
    }
}
