<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\Api\Socket3Controller;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Controllers\ControllerPrepare;

#[CoversClass(Socket3Controller::class)]
class Socket3ControllerTest extends ControllerPrepare
{
    public function testGetAllStatus(): void
    {
        $this->command = new Command(new CommandID('44'));
        $this->responseDataStub = $this->command->toString() . '13180000';
        $this->createServiceMock();
        $this->controller = new Socket3Controller($this->service);
        $expected = '{"success":true,"event":{"id":"44","description":"Socket3GetAllStatus","data":{"input":{"sensor0":{"sign":"+","temperature":19},"sensor1":{"sign":"+","temperature":24}},"relay":{"relay0":"Off","relay1":"Off"}}}}';

        $this->assertSame($expected, $this->controller->getAllStatus());
    }

    public function testGetSensor0(): void
    {
        $this->command = new Command(new CommandID('41'));
        $this->responseDataStub = $this->command->toString() . '13';
        $this->createServiceMock();
        $this->controller = new Socket3Controller($this->service);
        $expected = '{"success":true,"event":{"id":"41","description":"GetTemperatureSensor0","data":{"input":{"sensor0":{"sign":"+","temperature":19}}}}}';

        $this->assertSame($expected, $this->controller->getSensor0());
    }

    public function testGetSensor1(): void
    {
        $this->command = new Command(new CommandID('42'));
        $this->responseDataStub = $this->command->toString() . '18';
        $this->createServiceMock();
        $this->controller = new Socket3Controller($this->service);
        $expected = '{"success":true,"event":{"id":"42","description":"GetTemperatureSensor1","data":{"input":{"sensor1":{"sign":"+","temperature":24}}}}}';

        $this->assertSame($expected, $this->controller->getSensor1());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $this->command = new Command(new CommandID('43'), new Relay(0, 1, 5));
        $this->responseDataStub = $this->command->toString();
        $this->createServiceMock();
        $this->controller = new Socket3Controller($this->service);
        $expected = '{"success":true,"event":{"id":"43","description":"Socket3RelayAction","data":{"relay":{"relayNumber":0,"action":"On","interval":5}}}}';

        $this->assertSame($expected, $this->controller->relayAction($this->command->commandData));
    }
}
