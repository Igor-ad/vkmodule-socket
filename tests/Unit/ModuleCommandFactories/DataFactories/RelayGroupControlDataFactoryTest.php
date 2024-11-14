<?php

declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayGroupControlDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\TestCase;

class RelayGroupControlDataFactoryTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testMake()
    {
        $commandData = [
            'relayGroup' => [
                'relayGroupAction' => 'ffff',
            ],
        ];
        $factory = new RelayGroupControlDataFactory($commandData);
        $data = $factory->make();
        $this->assertTrue(is_a($data, RelayGroup::class));
    }
}
