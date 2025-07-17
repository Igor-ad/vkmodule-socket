<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\Console;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Console::class)]
class ConsoleTest extends TestCase
{
    public static function commandDataProvider(): array
    {
        return [
            'Connection' => [
                'command' => 'connection',
                'queryString' => null,
            ],
            'Reboot' => [
                'command' => 'reboot',
                'queryString' => null,
            ],
            'Firmware' => [
                'command' => 'firmware',
                'queryString' => null,
            ],
            'Uid' => [
                'command' => 'uid',
                'queryString' => null,
            ],
            'ApiConnection' => [
                'command' => 'api_connection',
                'queryString' => null,
            ],
            'ApiReboot' => [
                'command' => 'api_reboot',
                'queryString' => null,
            ],
            'ApiFirmware' => [
                'command' => 'api_firmware',
                'queryString' => null,
            ],
            'ApiUid' => [
                'command' => 'api_uid',
                'queryString' => null,
            ]
        ];
    }

    #[DataProvider('commandDataProvider')]
    public function testConstruct(string $command, ?string $queryString): void
    {
        $actual = new Console($command, $queryString);

        $this->assertInstanceOf(Console::class, $actual);
    }

    #[DataProvider('commandDataProvider')]
    public function testMake(string $command, ?string $queryString): void
    {
        $actual = Console::make($command, $queryString);

        $this->assertInstanceOf(Console::class, $actual);
    }
}
