<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testGetPath(): void
    {
        $path = dirname(__DIR__, 3);

        $this->assertEquals(
            expected: Files::ConfigFile->getPath(),
            actual: $path . Files::ConfigFile->value
        );
    }
}
