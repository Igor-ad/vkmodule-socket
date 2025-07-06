<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class Socket3CommandTest extends BaseCommandTestCase
{
    public static function commandDataProvider(): array
    {
        return [
            'GetTemperatureSensor0' => [
                'command' => 'input_temperature0',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '4119',
                'expectedString' => '{"success":true,"event":{"id":"41","description":"GetTemperatureSensor0","data":{"input":{"sensor0":{"sign":"+","temperature":25}}}}}',
            ],
            'GetTemperatureSensor1' => [
                'command' => 'input_temperature1',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '4217',
                'expectedString' => '{"success":true,"event":{"id":"42","description":"GetTemperatureSensor1","data":{"input":{"sensor1":{"sign":"+","temperature":23}}}}}',
            ],
            'Socket3RelayAction0' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '43000105',
                'expectedString' => '{"success":true,"event":{"id":"43","description":"Socket3RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}',
            ],
            'Socket3RelayAction1' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '43010105',
                'expectedString' => '{"success":true,"event":{"id":"43","description":"Socket3RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":5}}}}',
            ],
            'Socket3RelayActionOn' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '43010100',
                'expectedString' => '{"success":true,"event":{"id":"43","description":"Socket3RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":0}}}}',
            ],
            'Socket3RelayActionOff' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":0,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '43010000',
                'expectedString' => '{"success":true,"event":{"id":"43","description":"Socket3RelayAction","data":{"relay":{"relayNumber":1,"action":"Off","interval":0}}}}',
            ],
            'Socket3GetAllStatus' => [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-3"}}',
                'outgoingStream' => '4419170001',
                'expectedString' => '{"success":true,"event":{"id":"44","description":"Socket3GetAllStatus","data":{"input":{"sensor0":{"sign":"+","temperature":25},"sensor1":{"sign":"+","temperature":23}},"relay":{"relay0":"Off","relay1":"On"}}}}',
            ],
        ];
    }
}
