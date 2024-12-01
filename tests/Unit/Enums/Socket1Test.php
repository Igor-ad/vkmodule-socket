<?php declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Socket1;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket1::class)]
class Socket1Test extends TestCase
{
    public function testAllowedInput(): void
    {
        $expected = [0, 1, 2, 3];

        $this->assertSame($expected, Socket1::allowedInput());
    }
}
