<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket2;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket2::class)]
class Socket2Test extends TestCase
{
    public function testGetModuleCommands(): void
    {
        $expected = ['01', '02', '03', '04', '20', '21', '22', '23', '24'];

        $this->assertSame($expected, Socket2::getModuleCommands());
    }

    public function testResolveInputNumber(): void
    {
        $this->assertTrue(Socket2::resolveInput(Socket2::INPUT_END_NUMBER));
    }

    public function testResolveRelayNumber(): void
    {
        $this->assertTrue(Socket2::resolveRelay(Socket2::RELAY_END_NUMBER));
    }
}
