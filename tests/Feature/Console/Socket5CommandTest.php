<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class Socket5CommandTest extends AbstractCommand
{
    public static function commandDataProvider(): array
    {
        return [
            'SetInput0' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '20000105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":0,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput1' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '20010105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput2' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":2,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '20020105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":2,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput3' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":3,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '20030105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":3,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'GetInput' => [
                'command' => 'input_status',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '21010105',
                'expectedString' => '{"success":true,"event":{"id":"21","description":"GetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'RelayAction0' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '22000105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}',
            ],
            'RelayAction1' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '22010105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":5}}}}',
            ],
            'RelayAction2' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":2,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '22020105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":2,"action":"On","interval":5}}}}',
            ],
            'RelayAction3' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":3,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '22030105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":3,"action":"On","interval":5}}}}',
            ],
            'RelayActionOn' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '22010100',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":0}}}}',
            ],
            'RelayActionOff' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":0,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '22010000',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"Off","interval":0}}}}',
            ],
            'GetAllStatus' => [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-5"}}',
                'outgoingStream' => '230001000100010001',
                'expectedString' => '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"input":{"input0":"Closed","input1":"Open","input2":"Closed","input3":"Open"},"relay":{"relay0":"Off","relay1":"On","relay2":"Off","relay3":"On"}}}}',
            ],
        ];
    }
}
