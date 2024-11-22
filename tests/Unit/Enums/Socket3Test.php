<?php declare(strict_types=1);

namespace Enums;

use Autodoctor\ModuleSocket\Enums\Socket3;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket3::class)]
class Socket3Test extends TestCase
{
    public function testAllowedRelay(): void
    {
        $expected = [0, 1];

        $this->assertSame($expected, Socket3::allowedRelay());
    }
}
