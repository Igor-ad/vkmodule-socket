<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket1;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket1::class)]
class Socket1Test extends TestCase
{
    public function testGetModuleCommands(): void
    {
        $expected = ['01', '02', '03', '04', '30', '31', '32'];

        $this->assertSame($expected, Socket1::getModuleCommands());
    }

    public function testResolveInputNumber(): void
    {
        $this->assertTrue(Socket1::resolveInput(Socket1::INPUT_END_NUMBER));
    }

    public function testResolveRelayNumber(): void
    {
        $this->assertFalse(Socket1::resolveRelay(0));
    }
}
