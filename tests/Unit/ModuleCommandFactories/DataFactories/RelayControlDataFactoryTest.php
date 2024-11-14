<?php

declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayControlDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\TestCase;

class RelayControlDataFactoryTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testMake()
    {
        $commandData = [
            'relay' => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 20,
            ]
        ];
        $factory = new RelayControlDataFactory($commandData);
        $data = $factory->make();
        $this->assertTrue(is_a($data, Relay::class));
    }
}
