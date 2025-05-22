<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket3;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket3::class)]
class Socket3Test extends TestCase
{
    public function testAllowedInput(): void
    {
        $expected = [];

        $this->assertSame($expected, Socket3::allowedInput());
    }

    public function testAllowedRelay(): void
    {
        $expected = [0, 1];

        $this->assertSame($expected, Socket3::allowedRelay());
    }

    public function testGetModuleCommands(): void
    {
        $expected = ['01', '02', '03', '04', '41', '42', '43', '44'];

        $this->assertSame($expected, Socket3::getModuleCommands());
    }

    public function testCommands(): void
    {
        $expected = ['41', '42', '43', '44'];

        $this->assertSame($expected, Socket3::commands());
    }

    public function testResolveInputNumber(): void
    {
        $this->assertFalse(Socket3::resolveInput(0));
    }

    public function testResolveRelayNumber(): void
    {
        $this->assertTrue(Socket3::resolveRelay(Socket3::RELAY_END_NUMBER));
    }
}
