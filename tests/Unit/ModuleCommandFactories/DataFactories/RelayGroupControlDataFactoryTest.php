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
    public function testMake(): void
    {
        $commandData = [
            'relayGroup' => [
                'relayGroupAction' => 'ffff',
            ],
        ];
        $factory = new RelayGroupControlDataFactory($commandData);
        $data = $factory->make();
        $this->assertInstanceOf(RelayGroup::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());
    }
}
