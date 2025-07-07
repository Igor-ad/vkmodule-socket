<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

trait RequestDataProvider
{
    public static function requestDataProvider(): array
    {
        return [
            [
                'command' => 'connection',
                'queryString' => '{"command":{"id":"01"},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'reboot',
                'queryString' => '{"command":{"id":"02"},"connector":{"timeOut":3,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'firmware',
                'queryString' => '{"command":{"id":"03"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'uid',
                'queryString' => '{"command":{"id":"04"},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
            ],
            [
                'command' => 'input_setup',
                'queryString' => '{"command":{"id":"20","data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'input_status',
                'queryString' => '{"command":{"id":"21","data":{"input":{"inputNumber":0}}},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'relay_control',
                'queryString' => '{"command":{"id":"22","data":{"relay":{"relayNumber":0,"action":1,"interval":30}}},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'status',
                'queryString' => '{"command":{"id":"23"},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'input_analog',
                'queryString' => '{"command":{"id":"24"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
            ],
            [
                'command' => 'relay_group_control',
                'queryString' => '{"command":{"id":"25","data":{"relayGroup":{"relayGroupAction":"ffff"}}},"connector":{"type":"TCP","timeOut":3},"module":{"ip":"localhost","port":9761,"type":"Socket-Giant"}}',
            ],
            [
                'command' => 'input_setup',
                'queryString' => '{"command":{"id":"30","data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'input_status',
                'queryString' => '{"command":{"id":"31","data":{"input":{"inputNumber":0}}},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'status',
                'queryString' => '{"command":{"id":"32"},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-1"}}',
            ],
            [
                'command' => 'input_temperature0',
                'queryString' => '{"command":{"id":"41"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'input_temperature1',
                'queryString' => '{"command":{"id":"42"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'relay_control',
                'queryString' => '{"command":{"id":"43","data":{"relay":{"relayNumber":1,"action":1,"interval":50}}},"connector":{"type":"TCP","timeOut":10},"module":{"ip":"localhost","port":9761,"type":"Socket-3"}}',
            ],
            [
                'command' => 'status',
                'queryString' => '{"command":{"id":"44"},"connector":{"timeOut":10,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
            ],
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
