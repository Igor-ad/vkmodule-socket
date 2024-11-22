<?php declare(strict_types=1);

namespace Enums;

use Autodoctor\ModuleSocket\Enums\Socket5;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket5::class)]
class Socket5Test extends TestCase
{
    public function testAllowedInput(): void
    {
        $expected = [0, 1, 2, 3];

        $this->assertSame($expected, Socket5::allowedInput());
    }

    public function testAllowedRelay(): void
    {
        $expected = [0, 1, 2, 3];

        $this->assertSame($expected, Socket5::allowedRelay());
    }
}
