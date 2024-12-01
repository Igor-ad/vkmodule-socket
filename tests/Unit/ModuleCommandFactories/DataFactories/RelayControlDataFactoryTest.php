<?php declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\RelayControlDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelayControlDataFactory::class)]
class RelayControlDataFactoryTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testMake(): void
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

        $this->assertInstanceOf(Relay::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());

        $commandData = [
            'relay' => [
                'relayNumber' => 0,
                'action' => 10,
                'interval' => 2000,
            ]
        ];
        $factory = new RelayControlDataFactory($commandData);

        $this->expectException(InvalidInputParameterException::class);
        $factory->make();
    }
}
