<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class Socket4CommandTest extends BaseCommandTestCase
{
    public static function commandDataProvider(): array
    {
        return [
            'RelayAction0' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22000105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}',
            ],
            'RelayAction1' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22010105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":5}}}}',
            ],
            'RelayAction2' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":2,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22020105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":2,"action":"On","interval":5}}}}',
            ],
            'RelayAction3' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":3,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22030105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":3,"action":"On","interval":5}}}}',
            ],
            'RelayAction4' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":4,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22040105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":4,"action":"On","interval":5}}}}',
            ],
            'RelayAction5' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":5,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22050105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":5,"action":"On","interval":5}}}}',
            ],
            'RelayAction6' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":6,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22060105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":6,"action":"On","interval":5}}}}',
            ],
            'RelayAction7' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":7,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22070105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":7,"action":"On","interval":5}}}}',
            ],
            'RelayActionOn' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22010100',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":0}}}}',
            ],
            'RelayActionOff' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":0,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '22010000',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"Off","interval":0}}}}',
            ],
            'GetAllStatus' => [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-4"}}',
                'outgoingStream' => '230001000100010001',
                'expectedString' => '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"relay":{"relay0":"Off","relay1":"On","relay2":"Off","relay3":"On","relay4":"Off","relay5":"On","relay6":"Off","relay7":"On"}}}}',
            ],
        ];
    }
}
