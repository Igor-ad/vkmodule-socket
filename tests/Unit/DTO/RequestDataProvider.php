<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

trait RequestDataProvider
{
    public static function requestDataProvider(): array
    {
        return [
            [
                'command' => 'cli_full_control',
                'queryString' => '{"command":{"id":"43","data":{"relay":{"relayNumber":0,"action":1,"interval":30}}},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'connection',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'reboot',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'firmware',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'uid',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
            ],
            [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'input_status',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":30}}},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'status',
                'queryString' => '{"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'input_analog',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'relay_group_control',
                'queryString' => '{"command":{"data":{"relayGroup":{"relayGroupAction":"ffff"}}},"module":{"ip":"localhost","port":9761,"type":"Socket-Giant"}}',
            ],
            [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'input_status',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'status',
                'queryString' => '{"module":{"ip":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'input_temperature1',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'input_temperature0',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":50}}},"module":{"ip":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
        ];
    }
}
