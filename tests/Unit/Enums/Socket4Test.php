<?php declare(strict_types=1);

namespace Enums;

use Autodoctor\ModuleSocket\Enums\Socket4;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket4::class)]
class Socket4Test extends TestCase
{
    public function testAllowedRelay(): void
    {
        $expected = [0, 1, 2, 3, 4, 5, 6, 7];
        $this->assertSame($expected, Socket4::allowedRelay());
    }
}
