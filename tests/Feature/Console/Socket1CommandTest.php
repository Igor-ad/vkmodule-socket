<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class Socket1CommandTest extends BaseCommandTestCase
{
    public static function commandDataProvider(): array
    {
        return [
            'Socket1SetInput0' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
                'outgoingStream' => '30000105',
                'expectedString' => '{"success":true,"event":{"id":"30","description":"Socket1GetInput","data":{"input":{"inputNumber":0,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'Socket1SetInput1' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
                'outgoingStream' => '30010105',
                'expectedString' => '{"success":true,"event":{"id":"30","description":"Socket1GetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'Socket1SetInput2' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":2,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
                'outgoingStream' => '30020105',
                'expectedString' => '{"success":true,"event":{"id":"30","description":"Socket1GetInput","data":{"input":{"inputNumber":2,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'Socket1SetInput3' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":3,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
                'outgoingStream' => '30030105',
                'expectedString' => '{"success":true,"event":{"id":"30","description":"Socket1GetInput","data":{"input":{"inputNumber":3,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'Socket1GetInput' => [
                'command' => 'input_status',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
                'outgoingStream' => '31010105',
                'expectedString' => '{"success":true,"event":{"id":"31","description":"Socket1GetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'GetAllInput' => [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
                'outgoingStream' => '3200010001',
                'expectedString' => '{"success":true,"event":{"id":"32","description":"GetAllInput","data":{"input":{"input0":"Closed","input1":"Open","input2":"Closed","input3":"Open"}}}}',
            ],
        ];
    }
}
