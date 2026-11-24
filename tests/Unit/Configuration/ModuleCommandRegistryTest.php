<?php

declare(strict_types=1);

namespace Tests\Unit\Configuration;

use Autodoctor\ModuleSocket\Configuration\ModuleCommandRegistry;
use Autodoctor\ModuleSocket\Enums\ApiCommands;
use Autodoctor\ModuleSocket\Enums\CliCommands;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModuleCommandRegistry::class)]
class ModuleCommandRegistryTest extends TestCase
{
    public function testControllerMethodForKnownCommand(): void
    {
        $this->assertSame(
            'checkConnection',
            ModuleCommandRegistry::controllerMethodForCommandId(Commands::CheckConnect->value),
        );
        $this->assertSame(
            'relayAction',
            ModuleCommandRegistry::controllerMethodForCommandId(Commands::Socket3RelayAction->value),
        );
    }

    public function testControllerMethodForUnknownCommand(): void
    {
        $this->assertNull(ModuleCommandRegistry::controllerMethodForCommandId('11'));
    }

    public function testIsInputStatusCommandId(): void
    {
        $this->assertTrue(ModuleCommandRegistry::isInputStatusCommandId(Commands::GetInput->value));
        $this->assertTrue(ModuleCommandRegistry::isInputStatusCommandId(Commands::Socket1GetInput->value));
        $this->assertFalse(ModuleCommandRegistry::isInputStatusCommandId(Commands::SetInput->value));
    }

    public function testCardReaderHasNoControllerMethod(): void
    {
        $this->assertNull(ModuleCommandRegistry::controllerMethodForCommandId(Commands::MifareCard->value));
    }

    public function testUnknownSentinelHasNoControllerMethod(): void
    {
        $this->assertNull(ModuleCommandRegistry::controllerMethodForCommandId(Commands::UnknownCommand->value));
    }

    public function testApiPrefixIsAliasOfLogicalName(): void
    {
        foreach (CliCommands::cases() as $cliCommand) {
            $apiName = 'api_' . $cliCommand->value;

            $this->assertSame(
                ModuleCommandRegistry::resolveSurfaceNameToWireId($cliCommand->value, ModuleTypes::Socket3->value),
                ModuleCommandRegistry::resolveSurfaceNameToWireId($apiName, ModuleTypes::Socket3->value),
                $apiName,
            );
        }
    }

    public function testLogicalNameStripsOnlyLeadingApiPrefix(): void
    {
        $this->assertSame('relay_on', ModuleCommandRegistry::logicalName('api_relay_on'));
        $this->assertSame('relay_on', ModuleCommandRegistry::logicalName('relay_on'));
        $this->assertSame('my_api_x', ModuleCommandRegistry::logicalName('my_api_x'));
    }

    public function testResolveUnknownNameReturnsNull(): void
    {
        $this->assertNull(ModuleCommandRegistry::resolveSurfaceNameToWireId('no_such_command', 'Socket-2'));
        $this->assertNull(
            ModuleCommandRegistry::resolveSurfaceNameToWireId(CliCommands::CliFullControl->value, 'Socket-2'),
        );
    }

    public function testAllowedCommandIdsForUnknownModuleType(): void
    {
        $this->assertSame([], ModuleCommandRegistry::allowedCommandIdsForModuleType('no-such-hardware'));
    }

    public function testAllowedCommandIdsSocket1Shape(): void
    {
        $ids = ModuleCommandRegistry::allowedCommandIdsForModuleType(ModuleTypes::Socket1->value);
        $this->assertSame(['01', '02', '03', '04', '30', '31', '32'], $ids);
    }

    public function testIsWireCommandAllowedForModuleType(): void
    {
        $this->assertTrue(ModuleCommandRegistry::isWireCommandAllowedForModuleType(
            Commands::CheckConnect->value,
            ModuleTypes::Socket4->value,
        ));
        $this->assertFalse(ModuleCommandRegistry::isWireCommandAllowedForModuleType(
            Commands::SetInput->value,
            ModuleTypes::Socket4->value,
        ));
    }

    public function testIsWireSetInputCommandId(): void
    {
        $this->assertTrue(ModuleCommandRegistry::isWireSetInputCommandId(Commands::Socket1SetInput->value));
        $this->assertTrue(ModuleCommandRegistry::isWireSetInputCommandId(Commands::SetInput->value));
        $this->assertFalse(ModuleCommandRegistry::isWireSetInputCommandId(Commands::GetInput->value));
    }

    public function testSurfaceCommandRequiresRelayOrInputDeviceNumber(): void
    {
        $this->assertTrue(ModuleCommandRegistry::surfaceCommandRequiresRelayDeviceNumber(CliCommands::RelayOn->value));
        $this->assertTrue(
            ModuleCommandRegistry::surfaceCommandRequiresRelayDeviceNumber(ApiCommands::ApiRelayControl->value),
        );
        $this->assertFalse(
            ModuleCommandRegistry::surfaceCommandRequiresRelayDeviceNumber(CliCommands::Connection->value),
        );

        $this->assertTrue(
            ModuleCommandRegistry::surfaceCommandRequiresInputDeviceNumber(CliCommands::InputSetup->value),
        );
        $this->assertTrue(
            ModuleCommandRegistry::surfaceCommandRequiresInputDeviceNumber(ApiCommands::ApiInputStatus->value),
        );
        $this->assertFalse(ModuleCommandRegistry::surfaceCommandRequiresInputDeviceNumber(CliCommands::Status->value));
    }

    public function testResolveSurfaceNameToWireIdConnection(): void
    {
        $wire = ModuleCommandRegistry::resolveSurfaceNameToWireId(
            CliCommands::Connection->value,
            ModuleTypes::Socket2->value,
        );
        $this->assertSame(Common::Connect->value, $wire);
    }

    public function testResolveSurfaceNameToWireIdRelayDependsOnModuleType(): void
    {
        $this->assertSame(
            Commands::Socket3RelayAction->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::RelayOn->value,
                ModuleTypes::Socket3->value,
            ),
        );
        $this->assertSame(
            Commands::RelayAction->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::RelayOn->value,
                ModuleTypes::Socket2->value,
            ),
        );
    }

    public function testResolveSurfaceNameToWireIdStatusDependsOnModuleType(): void
    {
        $this->assertSame(
            Commands::GetAllInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::Status->value,
                ModuleTypes::Socket1->value,
            ),
        );
        $this->assertSame(
            Commands::Socket3GetAllStatus->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::Status->value,
                ModuleTypes::Socket3->value,
            ),
        );
        $this->assertSame(
            Commands::GetAllStatus->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::Status->value,
                ModuleTypes::Socket2->value,
            ),
        );
    }

    public function testResolveSurfaceNameToWireIdInputSetupAndStatus(): void
    {
        $this->assertSame(
            Commands::Socket1SetInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::InputSetup->value,
                ModuleTypes::Socket1->value,
            ),
        );
        $this->assertSame(
            Commands::SetInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::InputSetup->value,
                ModuleTypes::Socket2->value,
            ),
        );
        $this->assertSame(
            Commands::Socket1GetInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::InputStatus->value,
                ModuleTypes::Socket1->value,
            ),
        );
        $this->assertSame(
            Commands::GetInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                CliCommands::InputStatus->value,
                ModuleTypes::Socket2->value,
            ),
        );
        $this->assertSame(
            Commands::Socket1SetInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                ApiCommands::ApiInputSetup->value,
                ModuleTypes::Socket1->value,
            ),
        );
        $this->assertSame(
            Commands::GetInput->value,
            ModuleCommandRegistry::resolveSurfaceNameToWireId(
                ApiCommands::ApiInputStatus->value,
                ModuleTypes::Socket4->value,
            ),
        );
    }
}
