<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket2;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket2::class)]
class Socket2Test extends TestCase
{
    public function testAllowedInput(): void
    {
        $expected = [0, 1];

        $this->assertSame($expected, Socket2::allowedInput());
    }

    public function testAllowedRelay(): void
    {
        $expected = [0, 1];

        $this->assertSame($expected, Socket2::allowedRelay());
    }
}
