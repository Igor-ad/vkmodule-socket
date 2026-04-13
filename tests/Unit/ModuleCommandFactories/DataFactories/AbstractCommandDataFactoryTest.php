<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\AbstractCommandDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputSetupDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputStatusDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\NullCommandDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayControlDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayGroupControlDataFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractCommandDataFactory::class)]
class AbstractCommandDataFactoryTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

    public function testConstruct()
    {
        $factory = new NullCommandDataFactory();

        $this->assertInstanceOf(NullCommandDataFactory::class, $factory);
    }

    public function testGetInputSetupDataFactory()
    {
        $commandData = [
            CommandDataRootKey::Input->value => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ],
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null, $this->validator);

        $this->assertInstanceOf(InputSetupDataFactory::class, $factory);
    }

    public function testGetRelayDataFactory()
    {
        $commandData = [
            CommandDataRootKey::Relay->value => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 20,
            ]
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null, $this->validator);

        $this->assertInstanceOf(RelayControlDataFactory::class, $factory);
    }

    public function testGetInputStatusDataFactory()
    {
        $commandData = [
            CommandDataRootKey::Input->value => [
                'inputNumber' => 0,
            ]
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, Commands::GetInput->value, $this->validator);

        $this->assertInstanceOf(InputStatusDataFactory::class, $factory);
    }

    public function testGetRelayGroupControlDataFactory()
    {
        $commandData = [
            CommandDataRootKey::RelayGroup->value => [
                'relayGroupAction' => 'ffff',
            ],
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null, $this->validator);

        $this->assertInstanceOf(RelayGroupControlDataFactory::class, $factory);
    }

    public function testGetNullCommandDataFactory()
    {
        $commandData = null;
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null, $this->validator);

        $this->assertInstanceOf(NullCommandDataFactory::class, $factory);
    }
}
