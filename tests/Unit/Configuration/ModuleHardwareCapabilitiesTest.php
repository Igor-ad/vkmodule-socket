<?php

declare(strict_types=1);

namespace Tests\Unit\Configuration;

use Autodoctor\ModuleSocket\Configuration\ModuleHardwareCapabilities;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModuleHardwareCapabilities::class)]
class ModuleHardwareCapabilitiesTest extends TestCase
{
    public function testInputAllowedMatchesSocketEnums(): void
    {
        $this->assertTrue(ModuleHardwareCapabilities::isInputNumberAllowedForModuleType(0, ModuleTypes::Socket1->value));
        $this->assertTrue(ModuleHardwareCapabilities::isInputNumberAllowedForModuleType(1, ModuleTypes::Socket2->value));
        $this->assertFalse(ModuleHardwareCapabilities::isInputNumberAllowedForModuleType(99, ModuleTypes::Socket1->value));
        $this->assertFalse(ModuleHardwareCapabilities::isInputNumberAllowedForModuleType(0, ModuleTypes::Socket3->value));
    }

    public function testRelayAllowedMatchesSocketEnums(): void
    {
        $this->assertTrue(ModuleHardwareCapabilities::isRelayNumberAllowedForModuleType(0, ModuleTypes::Socket3->value));
        $this->assertFalse(ModuleHardwareCapabilities::isRelayNumberAllowedForModuleType(0, ModuleTypes::Socket1->value));
        $this->assertFalse(ModuleHardwareCapabilities::isRelayNumberAllowedForModuleType(99, ModuleTypes::SocketGiant->value));
    }

    public function testSocket3TemperatureRange(): void
    {
        $this->assertFalse(ModuleHardwareCapabilities::isSocket3TemperatureOutOfRange(24, 0));
        $this->assertTrue(ModuleHardwareCapabilities::isSocket3TemperatureOutOfRange(56, 1));
    }
}
