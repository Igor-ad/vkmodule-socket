<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class CommonCommandTest extends AbstractCommand
{
    public static function commandDataProvider(): array
    {
        return [
            'Connection' => [
                'command' => 'connection',
                'queryString' => '',
                'outgoingStream' => '01',
                'expectedString' => '{"success":true,"event":{"id":"01","description":"CheckConnect","data":{"status":"online"}}}',
            ],
            'Reboot' => [
                'command' => 'reboot',
                'queryString' => '',
                'outgoingStream' => '02',
                'expectedString' => '{"success":true,"event":{"id":"02","description":"RebootController","data":null}}',
            ],
            'Firmware' => [
                'command' => 'firmware',
                'queryString' => '',
                'outgoingStream' => '0304010907',
                'expectedString' => '{"success":true,"event":{"id":"03","description":"GetFirmware","data":{"controllerType":"Socket-3","version":"0109","firmwareType":"exclusive","firmware":"04010907"}}}',
            ],
            'Uid' => [
                'command' => 'uid',
                'queryString' => '',
                'outgoingStream' => '040369',
                'expectedString' => '{"success":true,"event":{"id":"04","description":"GetUid","data":{"uid":873}}}',
            ]
        ];
    }
}
