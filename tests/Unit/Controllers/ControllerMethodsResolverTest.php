<?php declare(strict_types=1);

namespace Controllers;

use Autodoctor\ModuleSocket\Controllers\ControllerMethodsResolver;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionException;

class ControllerMethodsResolverTest extends TestCase
{
    protected object $object;
    protected ReflectionMethod $reflectionResolve;

    /**
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $this->object = new class() {
            use ControllerMethodsResolver;
        };

        $this->reflectionResolve = new ReflectionMethod($this->object, 'resolve');
    }

    public static function resolverDataProvider(): array
    {
        return [
            [Commands::CheckConnect->value, 'checkConnection'],
            [Commands::RebootController->value, 'rebootModule'],
            [Commands::GetFirmware->value, 'getModuleFirmware'],
            [Commands::GetUid->value, 'getModuleUID'],
            [Commands::SetInput->value, 'inputSetup'],
            [Commands::Socket1SetInput->value, 'inputSetup'],
            [Commands::GetInput->value, 'getInput'],
            [Commands::Socket1GetInput->value, 'getInput'],
            [Commands::RelayAction->value, 'relayAction'],
            [Commands::Socket3RelayAction->value, 'relayAction'],
            [Commands::GetAllStatus->value, 'getAllStatus'],
            [Commands::GetAllInput->value, 'getAllStatus'],
            [Commands::Socket3GetAllStatus->value, 'getAllStatus'],
            [Commands::GetAnalogInput->value, 'getAnalogInput'],
            [Commands::GetTemperatureSensor0->value, 'getSensor0'],
            [Commands::GetTemperatureSensor1->value, 'getSensor1'],
            [Commands::RelayGroupAction->value, 'relayGroupAction'],
        ];
    }

    /**
     * @throws ReflectionException
     */
    #[DataProvider('resolverDataProvider')]
    public function testResolve(string $commandId, string $expectedResolvedMethod): void
    {
        $this->assertSame($expectedResolvedMethod, $this->reflectionResolve->invoke($this->object, $commandId));
    }

    /**
     * @throws ReflectionException
     */
    public function testExceptionResolve(): void
    {
        $this->expectException(ModuleException::class);

        $this->reflectionResolve->invoke($this->object, '11');
    }
}
