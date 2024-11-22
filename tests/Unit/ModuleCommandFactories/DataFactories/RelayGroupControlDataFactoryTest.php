<?php declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayGroupControlDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelayGroupControlDataFactory::class)]
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

        $commandData = [
            'relayGroup' => [
                'relayGroupAction' => 'ffffaa',
            ],
        ];
        $factory = new RelayGroupControlDataFactory($commandData);

        $this->expectException(InvalidInputParameterException::class);
        $factory->make();
    }
}
