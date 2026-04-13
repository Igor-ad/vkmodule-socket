<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Autodoctor\ModuleSocket\Controllers\AbstractModuleController;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(AbstractModuleController::class)]
class AbstractModuleControllerTest extends ControllerInit
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(ControllerInterface::class, $this->controller);
    }

    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function stubMethodDataProvider(): array
    {
        return [
            'getAllStatus' => ['getAllStatus', false],
            'getAnalogInput' => ['getAnalogInput', false],
            'getSensor0' => ['getSensor0', false],
            'getSensor1' => ['getSensor1', false],
            'getInput' => ['getInput', true],
            'inputSetup' => ['inputSetup', true],
            'relayAction' => ['relayAction', true],
            'relayGroupAction' => ['relayGroupAction', true],
        ];
    }

    #[DataProvider('stubMethodDataProvider')]
    public function testDefaultStubMethodsReturnEmptyString(string $method, bool $needsCommandData): void
    {
        $commandData = $this->createMock(CommandData::class);
        $controller = $this->controller;

        $result = $needsCommandData
            ? $controller->{$method}($commandData)
            : $controller->{$method}();

        $this->assertSame('', $result);
    }
}
