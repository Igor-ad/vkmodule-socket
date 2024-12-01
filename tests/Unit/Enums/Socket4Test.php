<?php declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket4;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket4::class)]
class Socket4Test extends TestCase
{
    public function testAllowedRelay(): void
    {
        $expected = range(0, 7);

        $this->assertSame($expected, Socket4::allowedRelay());
    }
}
