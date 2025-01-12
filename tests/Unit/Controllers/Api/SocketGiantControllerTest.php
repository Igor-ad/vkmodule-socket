<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\Api\SocketGiantController;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Controllers\ControllerPrepare;

#[CoversClass(SocketGiantController::class)]
class SocketGiantControllerTest extends ControllerPrepare
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup(): void
    {
        $this->command = new Command(new CommandID('20'), new Input(0, 0, 5));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new SocketGiantController($this->service);
        $expected = '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":0,"triggerAction":"Closed","antiBounce":5}}}}';

        $this->assertSame($expected, $this->controller->inputSetup($this->command->commandData));
    }

    public function testGetInput(): void
    {
        $this->command = new Command(new CommandID('21'), new InputStatus(0));
        $this->responseDataStub = '20000005';
        $this->createServiceMock();
        $this->controller = new SocketGiantController($this->service);
        $expected = '{"success":true,"event":{"id":"20","description":"SetInput","data":{"input":{"inputNumber":0,"triggerAction":"Closed","antiBounce":5}}}}';

        $this->assertSame($expected, $this->controller->getInput($this->command->commandData));
    }

    public function testGetAllStatus(): void
    {
        $this->command = new Command(new CommandID('23'));
        $this->responseDataStub = $this->command->toString() . '00000000';
        $this->createServiceMock();
        $this->controller = new SocketGiantController($this->service);
        $expected = '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"input":{"input0":"Closed","input1":"Closed","input2":"Closed","input3":"Closed","input4":"Closed","input5":"Closed","input6":"Closed","input7":"Closed","input8":"Closed","input9":"Closed","input10":"Closed","input11":"Closed","input12":"Closed","input13":"Closed","input14":"Closed","input15":"Closed"},"relay":{"relay0":"Off","relay1":"Off","relay2":"Off","relay3":"Off","relay4":"Off","relay5":"Off","relay6":"Off","relay7":"Off","relay8":"Off","relay9":"Off","relay10":"Off","relay11":"Off","relay12":"Off","relay13":"Off","relay14":"Off","relay15":"Off"}}}}';

        $this->assertSame($expected, $this->controller->getAllStatus());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $this->command = new Command(new CommandID('22'), new Relay(0, 1, 5));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new SocketGiantController($this->service);
        $expected = '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}';

        $this->assertSame($expected, $this->controller->relayAction($this->command->commandData));
    }

    public function testRelayGroupAction(): void
    {
        $this->command = new Command(new CommandID('25'), new RelayGroup('ffff'));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new SocketGiantController($this->service);
        $expected = '{"success":true,"event":{"id":"25","description":"RelayGroupAction","data":{"relay":{"relay0":"On","relay1":"On","relay2":"On","relay3":"On","relay4":"On","relay5":"On","relay6":"On","relay7":"On","relay8":"On","relay9":"On","relay10":"On","relay11":"On","relay12":"On","relay13":"On","relay14":"On","relay15":"On"}}}}';

        $this->assertSame($expected, $this->controller->relayGroupAction($this->command->commandData));
    }
}
