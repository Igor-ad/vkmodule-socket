<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\Api\Socket5Controller;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Controllers\ControllerPrepare;

#[CoversClass(Socket5Controller::class)]
class Socket5ControllerTest extends ControllerPrepare
{
    public function testGetAllStatus(): void
    {
        $this->command = new Command(new CommandID('23'));
        $this->responseDataStub = $this->command->toString() . '0000010100000101';
        $this->createServiceMock();
        $this->controller = new Socket5Controller($this->service);
        $expected = '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"input":{"input0":"Closed","input1":"Closed","input2":"Open","input3":"Open"},"relay":{"relay0":"Off","relay1":"Off","relay2":"On","relay3":"On"}}}}';

        $this->assertSame($expected, $this->controller->getAllStatus());
    }

    public function testGetInput(): void
    {
        $this->command = new Command(new CommandID('21'), new InputStatus(0));
        $this->responseDataStub = '20000005';
        $this->createServiceMock();
        $this->controller = new Socket5Controller($this->service);
        $expected = '{"success":true,"event":{"id":"20","description":"GetInput","data":{"input":{"inputNumber":0,"triggerAction":"Closed","antiBounce":5}}}}';

        $this->assertSame($expected, $this->controller->getInput($this->command->commandData));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup(): void
    {
        $this->command = new Command(new CommandID('20'), new Input(0, 0, 5));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new Socket5Controller($this->service);
        $expected = '{"success":true,"event":{"id":"20","description":"GetInput","data":{"input":{"inputNumber":0,"triggerAction":"Closed","antiBounce":5}}}}';

        $this->assertSame($expected, $this->controller->inputSetup($this->command->commandData));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $this->command = new Command(new CommandID('22'), new Relay(0, 1, 5));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new Socket5Controller($this->service);
        $expected = '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}';

        $this->assertSame($expected, $this->controller->relayAction($this->command->commandData));
    }
}
