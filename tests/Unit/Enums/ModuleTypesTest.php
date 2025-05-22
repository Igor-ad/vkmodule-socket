<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ModuleTypesTest extends TestCase
{
    public static function moduleTypeDataProvider(): array
    {
        return [
            ['Socket-1'],
            ['Socket-2'],
            ['Socket-3'],
            ['Socket-4'],
            ['Socket-5'],
            ['Socket-Giant'],
        ];
    }

    public function testValues(): void
    {
        $expected = [
            'Socket-1',
            'Socket-2',
            'Socket-3',
            'Socket-4',
            'Socket-5',
            'Socket-Giant',
        ];

        $this->assertSame(expected: $expected, actual: ModuleTypes::values());
    }

    #[DataProvider('moduleTypeDataProvider')]
    public function testValidateType(string $type): void
    {
        $this->assertTrue(ModuleTypes::validateType($type));
    }
}
