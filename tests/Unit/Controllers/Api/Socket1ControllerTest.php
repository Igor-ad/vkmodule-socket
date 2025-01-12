<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\Controllers\Api\Socket1Controller;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Controllers\ControllerPrepare;

#[CoversClass(Socket1Controller::class)]
class Socket1ControllerTest extends ControllerPrepare
{
    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup(): void
    {
        $this->command = new Command(new CommandID('30'), new Input(0, 0, 5));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new Socket1Controller($this->service);
        $expected = '{"success":true,"event":{"id":"30","description":"Socket1SetInput","data":{"input":{"inputNumber":0,"triggerAction":"Closed","antiBounce":5}}}}';

        $this->assertSame($expected, $this->controller->inputSetup($this->command->commandData));
    }

    public function testGetAllStatus(): void
    {
        $this->command = new Command(new CommandID('32'));
        $this->responseDataStub = $this->command->toString() . '00000101';
        $this->createServiceMock();
        $this->controller = new Socket1Controller($this->service);
        $expected = '{"success":true,"event":{"id":"32","description":"GetAllInput","data":{"input":{"input0":"Closed","input1":"Closed","input2":"Open","input3":"Open"}}}}';

        $this->assertSame($expected, $this->controller->getAllStatus());
    }

    public function testGetInput(): void
    {
        $this->command = new Command(new CommandID('31'), new InputStatus(01));
        $this->responseDataStub = '30000005';
        $this->createServiceMock();
        $this->controller = new Socket1Controller($this->service);
        $expected = '{"success":true,"event":{"id":"30","description":"Socket1SetInput","data":{"input":{"inputNumber":0,"triggerAction":"Closed","antiBounce":5}}}}';

        $this->assertSame($expected, $this->controller->getInput($this->command->commandData));
    }
}
