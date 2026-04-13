<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayControlDataFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelayControlDataFactory::class)]
class RelayControlDataFactoryTest extends TestCase
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
            CommandDataRootKey::Relay->value => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 20,
            ]
        ];
        $factory = new RelayControlDataFactory($commandData, $this->validator);
        $data = $factory->make();

        $this->assertInstanceOf(Relay::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());

        $commandData = [
            CommandDataRootKey::Relay->value => [
                'relayNumber' => 0,
                'action' => 10,
                'interval' => 2000,
            ]
        ];
        $factory = new RelayControlDataFactory($commandData, $this->validator);

        $this->expectException(InvalidInputParameterException::class);
        $factory->make();
    }
}
