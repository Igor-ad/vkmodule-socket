<?php

declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\AbstractCommandDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputSetupDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputStatusDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\NullCommandDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayControlDataFactory;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayGroupControlDataFactory;
use PHPUnit\Framework\TestCase;

class AbstractCommandDataFactoryTest extends TestCase
{
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
        $this->assertTrue(is_a($factory, InputSetupDataFactory::class));

        $commandData = [
            'relay' => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 20,
            ]
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertTrue(is_a($factory, RelayControlDataFactory::class));

        $commandData = [
            'input' => [
                'inputNumber' => 0,
            ]
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, '21');
        $this->assertTrue(is_a($factory, InputStatusDataFactory::class));

        $commandData = [
            'relayGroup' => [
                'relayGroupAction' => 'ffff',
            ],
        ];
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertTrue(is_a($factory, RelayGroupControlDataFactory::class));

        $commandData = null;
        $factory = AbstractCommandDataFactory::getDataFactory($commandData, null);
        $this->assertTrue(is_a($factory, NullCommandDataFactory::class));
    }
}
