<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

class SocketGiantCommandTest extends BaseCommandTestCase
{
    public static function commandDataProvider(): array
    {
        return [
            'SetInput0' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20000105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":0,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput1' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20010105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput2' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":2,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20020105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":2,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput3' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":3,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20030105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":3,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput4' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":4,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20040105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":4,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput5' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":5,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20050105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":5,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput6' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":6,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20060105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":6,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput7' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":7,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20070105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":7,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput8' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":8,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20080105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":8,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput9' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":9,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '20090105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":9,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput10' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":10,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '200a0105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":10,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput11' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":11,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '200b0105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":11,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput12' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":12,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '200c0105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":12,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput13' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":13,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '200d0105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":13,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput14' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":14,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '200e0105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":14,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'SetInput15' => [
                'command' => 'input_setup',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":15,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '200f0105',
                'expectedString' => '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":15,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'GetInput' => [
                'command' => 'input_status',
                'queryString' => '{"command":{"data":{"input":{"inputNumber":1}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '21010105',
                'expectedString' => '{"success":true,"event":{"id":"21","description":"GetInput","data":{"input":{"inputNumber":1,"triggerAction":"Open","antiBounce":5}}}}',
            ],
            'RelayAction0' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22000105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}',
            ],
            'RelayAction1' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22010105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":5}}}}',
            ],
            'RelayAction2' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":2,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22020105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":2,"action":"On","interval":5}}}}',
            ],
            'RelayAction3' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":3,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22030105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":3,"action":"On","interval":5}}}}',
            ],
            'RelayAction4' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":4,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22040105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":4,"action":"On","interval":5}}}}',
            ],
            'RelayAction5' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":5,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22050105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":5,"action":"On","interval":5}}}}',
            ],
            'RelayAction6' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":6,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22060105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":6,"action":"On","interval":5}}}}',
            ],
            'RelayAction7' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":7,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22070105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":7,"action":"On","interval":5}}}}',
            ],
            'RelayAction8' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":8,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22080105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":8,"action":"On","interval":5}}}}',
            ],
            'RelayAction9' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":9,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22090105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":9,"action":"On","interval":5}}}}',
            ],
            'RelayAction10' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":10,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '220a0105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":10,"action":"On","interval":5}}}}',
            ],
            'RelayAction11' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":11,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '220b0105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":11,"action":"On","interval":5}}}}',
            ],
            'RelayAction12' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":12,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '220c0105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":12,"action":"On","interval":5}}}}',
            ],
            'RelayAction13' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":13,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '220d0105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":13,"action":"On","interval":5}}}}',
            ],
            'RelayAction14' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":14,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '220e0105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":14,"action":"On","interval":5}}}}',
            ],
            'RelayAction15' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":15,"action":1,"interval":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '220f0105',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":15,"action":"On","interval":5}}}}',
            ],
            'RelayActionOn' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":1,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22010100',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"On","interval":0}}}}',
            ],
            'RelayActionOff' => [
                'command' => 'relay_control',
                'queryString' => '{"command":{"data":{"relay":{"relayNumber":1,"action":0,"interval":0}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '22010000',
                'expectedString' => '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":1,"action":"Off","interval":0}}}}',
            ],
            'GetAllStatus' => [
                'command' => 'status',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '23aaaaaaaa',
                'expectedString' => '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"input":{"input0":"Open","input1":"Closed","input2":"Open","input3":"Closed","input4":"Open","input5":"Closed","input6":"Open","input7":"Closed","input8":"Open","input9":"Closed","input10":"Open","input11":"Closed","input12":"Open","input13":"Closed","input14":"Open","input15":"Closed"},"relay":{"relay0":"On","relay1":"Off","relay2":"On","relay3":"Off","relay4":"On","relay5":"Off","relay6":"On","relay7":"Off","relay8":"On","relay9":"Off","relay10":"On","relay11":"Off","relay12":"On","relay13":"Off","relay14":"On","relay15":"Off"}}}}',
            ],
            'RelayGroupAction' => [
                'command' => 'relay_group_control',
                'queryString' => '{"command":{"data":{"relayGroup":{"relayGroupAction":"aaaa"}}},"module":{"host":"localhost","port":9761,"type":"Socket-Giant"}}',
                'outgoingStream' => '25aaaa',
                'expectedString' => '{"success":true,"event":{"id":"25","description":"RelayGroupAction","data":{"relay":{"relay0":"On","relay1":"Off","relay2":"On","relay3":"Off","relay4":"On","relay5":"Off","relay6":"On","relay7":"Off","relay8":"On","relay9":"Off","relay10":"On","relay11":"Off","relay12":"On","relay13":"Off","relay14":"On","relay15":"Off"}}}}',
            ],
        ];
    }
}
