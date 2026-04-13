<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Files::class)]
class FilesTest extends TestCase
{
    public function testGetPath(): void
    {
        $path = dirname(__DIR__, 3);

        $this->assertSame(
            $path . DIRECTORY_SEPARATOR . ltrim(Files::ConfigFile->value, '/'),
            Files::ConfigFile->getPath(),
        );
    }
}
