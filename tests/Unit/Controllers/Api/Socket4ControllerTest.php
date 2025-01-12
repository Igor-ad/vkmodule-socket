<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\Api\Socket4Controller;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Controllers\ControllerPrepare;

#[CoversClass(Socket4Controller::class)]
class Socket4ControllerTest extends ControllerPrepare
{
    public function testGetAllStatus(): void
    {
        $this->command = new Command(new CommandID('23'));
        $this->responseDataStub = $this->command->toString() . '0000000001010101';
        $this->createServiceMock();
        $this->controller = new Socket4Controller($this->service);
        $expected = '{"success":true,"event":{"id":"23","description":"GetAllStatus","data":{"relay":{"relay0":"Off","relay1":"Off","relay2":"Off","relay3":"Off","relay4":"On","relay5":"On","relay6":"On","relay7":"On"}}}}';

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
        $this->controller = new Socket4Controller($this->service);
        $expected = '{"success":true,"event":{"id":"22","description":"RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}';

        $this->assertSame($expected, $this->controller->relayAction($this->command->commandData));
    }
}
