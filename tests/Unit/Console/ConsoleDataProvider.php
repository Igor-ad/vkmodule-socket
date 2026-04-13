<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

trait ConsoleDataProvider
{
    public static function commandDataProvider(): array
    {
        return [
            'Connection' => [
                'commandName' => 'connection',
                'queryString' => null,
            ],
            'Reboot' => [
                'commandName' => 'reboot',
                'queryString' => null,
            ],
            'Firmware' => [
                'commandName' => 'firmware',
                'queryString' => null,
            ],
            'Uid' => [
                'commandName' => 'uid',
                'queryString' => null,
            ],
            'ApiConnection' => [
                'commandName' => 'api_connection',
                'queryString' => null,
            ],
            'ApiReboot' => [
                'commandName' => 'api_reboot',
                'queryString' => null,
            ],
            'ApiFirmware' => [
                'commandName' => 'api_firmware',
                'queryString' => null,
            ],
            'ApiUid' => [
                'commandName' => 'api_uid',
                'queryString' => null,
            ]
        ];
    }

    public static function results(): array
    {
        return [
            'Connection' => [
                'expectedResult' => 0,
            ],
            'Reboot' => [
                'expectedResult' => 0,
            ],
            'Firmware' => [
                'expectedResult' => 0,
            ],
            'Uid' => [
                'expectedResult' => 0,
            ],
            'ApiConnection' => [
                'expectedResult' => '{"success":true,"event":{"id":"01","description":"CheckConnect","data":{"status":"online"}}}',
            ],
            'ApiReboot' => [
                'expectedResult' => '{"success":true,"event":{"id":"02","description":"RebootController","data":null}}',
            ],
            'ApiFirmware' => [
                'expectedResult' => '{"success":true,"event":{"id":"03","description":"GetFirmware","data":{"controllerType":"Socket-3","version":"0109","firmwareType":"exclusive","firmware":"04010907"}}}',
            ],
            'ApiUid' => [
                'expectedResult' => '{"success":true,"event":{"id":"04","description":"GetUid","data":{"uid":873}}}',
            ]
        ];
    }

    public static function commandWithResultDataProvider(): array
    {
        return array_merge_recursive(
            self::commandDataProvider(),
            self::results(),
        );
    }
}
