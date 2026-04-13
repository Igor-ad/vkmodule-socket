<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputSetupDataFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InputSetupDataFactory::class)]
class InputSetupDataFactoryTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testMake(): void
    {
        $commandData = [
            CommandDataRootKey::Input->value => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ],
        ];
        $factory = new InputSetupDataFactory($commandData, $this->validator);
        $data = $factory->make();

        $this->assertInstanceOf(Input::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());

        $commandData = [
            CommandDataRootKey::Input->value => [
                'inputNumber' => 0,
                'action' => 10,
                'antiBounce' => 5000,
            ],
        ];
        $factory = new InputSetupDataFactory($commandData, $this->validator);

        $this->expectException(InvalidInputParameterException::class);
        $factory->make();
    }
}
