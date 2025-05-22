<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Common;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Common::class)]
class CommonTest extends TestCase
{
    public function testCommands(): void
    {
        $expected = ['01', '02', '03', '04'];

        $this->assertEquals($expected, Common::commands());
    }
}
