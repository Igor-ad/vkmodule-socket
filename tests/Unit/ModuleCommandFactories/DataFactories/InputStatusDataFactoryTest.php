<?php declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\InputStatusDataFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InputStatusDataFactory::class)]
class InputStatusDataFactoryTest extends TestCase
{
    public function testMake(): void
    {
        $commandData = [
            'input' => [
                'inputNumber' => 0,
            ]
        ];
        $factory = new InputStatusDataFactory($commandData);
        $data = $factory->make();

        $this->assertInstanceOf(InputStatus::class, $data);
        $this->assertSame(expected: $commandData, actual: $data->toArray());
    }
}
