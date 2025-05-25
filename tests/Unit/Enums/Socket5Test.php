<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket5;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket5::class)]
class Socket5Test extends TestCase
{
    public function testGetModuleCommands(): void
    {
        $expected = ['01', '02', '03', '04', '20', '21', '22', '23'];

        $this->assertSame($expected, Socket5::getModuleCommands());
    }

    public function testResolveInputNumber(): void
    {
        $this->assertTrue(Socket5::resolveInput(Socket5::INPUT_END_NUMBER));
    }

    public function testResolveRelayNumber(): void
    {
        $this->assertTrue(Socket5::resolveRelay(Socket5::RELAY_END_NUMBER));
    }
}
