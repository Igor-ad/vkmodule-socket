<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputStatusDataFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InputStatusDataFactory::class)]
class InputStatusDataFactoryTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

    public function testMake(): void
    {
        $commandData = [
            CommandDataRootKey::Input->value => [
                'inputNumber' => 0,
            ]
        ];
        $factory = new InputStatusDataFactory($commandData, $this->validator);
        $data = $factory->make();

        $this->assertInstanceOf(InputStatus::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());
    }
}
