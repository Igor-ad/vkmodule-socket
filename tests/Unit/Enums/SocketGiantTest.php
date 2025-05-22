<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\SocketGiant;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SocketGiant::class)]
class SocketGiantTest extends TestCase
{
    public function testAllowedInput(): void
    {
        $expected = range(0, 15);

        $this->assertSame($expected, SocketGiant::allowedInput());
    }

    public function testAllowedRelay(): void
    {
        $expected = range(0, 15);

        $this->assertSame($expected, SocketGiant::allowedRelay());
    }


    public function testGetModuleCommands(): void
    {
        $expected = ['01', '02', '03', '04', '20', '21', '22', '23', '25'];

        $this->assertSame($expected, SocketGiant::getModuleCommands());
    }

    public function testCommands(): void
    {
        $expected = ['20', '21', '22', '23', '25'];

        $this->assertSame($expected, SocketGiant::commands());
    }

    public function testResolveInputNumber(): void
    {
        $this->assertTrue(SocketGiant::resolveInput(SocketGiant::INPUT_END_NUMBER));
    }

    public function testResolveRelayNumber(): void
    {
        $this->assertTrue(SocketGiant::resolveRelay(SocketGiant::RELAY_END_NUMBER));
    }
}
