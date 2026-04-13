<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayGroupControlDataFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelayGroupControlDataFactory::class)]
class RelayGroupControlDataFactoryTest extends TestCase
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
            CommandDataRootKey::RelayGroup->value => [
                'relayGroupAction' => 'ffff',
            ],
        ];
        $factory = new RelayGroupControlDataFactory($commandData, $this->validator);
        $data = $factory->make();

        $this->assertInstanceOf(RelayGroup::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());

        $commandData = [
            CommandDataRootKey::RelayGroup->value => [
                'relayGroupAction' => 'ffffaa',
            ],
        ];
        $factory = new RelayGroupControlDataFactory($commandData, $this->validator);

        $this->expectException(InvalidInputParameterException::class);
        $factory->make();
    }
}
