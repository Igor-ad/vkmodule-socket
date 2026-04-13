<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandDataRootKey::class)]
class CommandDataRootKeyTest extends TestCase
{
    /**
     * @return array<string, array{0: CommandDataRootKey, 1: string}>
     */
    public static function caseDataProvider(): array
    {
        return [
            'input' => [CommandDataRootKey::Input, 'input'],
            'relay' => [CommandDataRootKey::Relay, 'relay'],
            'relay_group' => [CommandDataRootKey::RelayGroup, 'relayGroup'],
        ];
    }

    #[DataProvider('caseDataProvider')]
    public function testBackedValues(CommandDataRootKey $case, string $expected): void
    {
        $this->assertSame($expected, $case->value);
    }
}
