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
}
