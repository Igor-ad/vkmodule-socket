<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket4;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket4::class)]
class Socket4Test extends TestCase
{
    public function testAllowedInput(): void
    {
        $expected = [];

        $this->assertSame($expected, Socket4::allowedInput());
    }

    public function testAllowedRelay(): void
    {
        $expected = range(0, 7);

        $this->assertSame($expected, Socket4::allowedRelay());
    }

    public function testGetModuleCommands(): void
    {
        $expected = ['01', '02', '03', '04', '22', '23'];

        $this->assertSame($expected, Socket4::getModuleCommands());
    }

    public function testCommands(): void
    {
        $expected = ['22', '23'];

        $this->assertSame($expected, Socket4::commands());
    }

    public function testResolveInputNumber(): void
    {
        $this->assertFalse(Socket4::resolveInput(0));
    }

    public function testResolveRelayNumber(): void
    {
        $this->assertTrue(Socket4::resolveRelay(Socket4::RELAY_END_NUMBER));
    }
}
