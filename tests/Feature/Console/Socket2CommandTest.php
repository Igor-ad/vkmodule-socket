<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class Socket2CommandTest extends BaseCommandTestCase
{
    public static function commandDataProvider(): array
    {
        return [
            'SetInput0' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '20000105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"GetInput","data":{"input":{"inputNumber":0,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput1' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '20010105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"GetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'GetInput' => [
                'command' => 'input_status',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '21010105',
                'expectedString' => '{"success":true,"event":{"id":"21","description":"GetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'RelayAction0' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '22000105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}',
            ],
            'RelayAction1' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '22010105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":5}}}}',
            ],
            'RelayActionOn' => [
                'command' => 'relay_on',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '22010100',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":0}}}}',
            ],
            'RelayActionOff' => [
                'command' => 'relay_off',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '22010000',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"Off","interval":0}}}}',
            ],
            'GetAllStatus' => [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '2301010101',
                'expectedString' => '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"input":{"input0":"Open","input1":"Open"},"relay":{"relay0":"On","relay1":"On"}}}}',
            ],
            'GetAnalogInput' => [
                'command' => 'input_analog',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-2"}}',
                'outgoingStream' => '240201',
                'expectedString' => '{"success":true,"event":{"id":"24","description":"GetAnalogInput","data":{"input":{"voltage":0.5009765625}}}}',
            ],
        ];
    }
}
