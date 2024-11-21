<?php declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\AbstractCommandDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputSetupDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputStatusDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\NullCommandDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayControlDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayGroupControlDataFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractCommandDataFactory::class)]
class AbstractCommandDataFactoryTest extends TestCase
{
    public function test__construct()
    {
        $factory = new NullCommandDataFactory();
        $this->assertInstanceOf(NullCommandDataFactory::class, $factory);
    }

    public function testGetDataFactory()
    {
        $commandData = [
            'input' => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ],
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertInstanceOf(InputSetupDataFactory::class, $factory);

        $commandData = [
            'relay' => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 20,
            ]
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertInstanceOf(RelayControlDataFactory::class, $factory);

        $commandData = [
            'input' => [
                'inputNumber' => 0,
            ]
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, '21');
        $this->assertInstanceOf(InputStatusDataFactory::class, $factory);

        $commandData = [
            'relayGroup' => [
                'relayGroupAction' => 'ffff',
            ],
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertInstanceOf(RelayGroupControlDataFactory::class, $factory);

        $commandData = null;
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertInstanceOf(NullCommandDataFactory::class, $factory);
    }
}
