<?php declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\Api\Controller;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Tests\Unit\Controllers\ControllerPrepare;

class ControllerTest extends ControllerPrepare
{
    public function testCheckConnection(): void
    {
        $this->responseDataStub = '01';
        $this->command = new Command(new CommandID('01'));
        $this->createServiceMock();
        $this->controller = new Controller($this->service);
        $expected = '{"success":true,"event":{"id":"01","description":"CheckConnect","data":{"status":"online"}}}';

        $this->assertSame($expected, $this->controller->checkConnection());
    }

    public function testGetModuleFirmware(): void
    {
        $this->responseDataStub = '03040000';
        $this->command = new Command(new CommandID('03'));
        $this->createServiceMock();
        $this->controller = new Controller($this->service);
        $expected = '{"success":true,"event":{"id":"03","description":"GetFirmware","data":{"controllerType":"Socket-3","version":"0000","firmwareType":"regular","firmware":"040000"}}}';

        $this->assertSame($expected, $this->controller->getModuleFirmware());
    }

    public function testGetModuleUID(): void
    {
        $this->responseDataStub = '040369';
        $this->command = new Command(new CommandID('04'));
        $this->createServiceMock();
        $this->controller = new Controller($this->service);
        $expected = '{"success":true,"event":{"id":"04","description":"GetUid","data":{"uid":873}}}';

        $this->assertSame($expected, $this->controller->getModuleUID());
    }

    public function testRebootModule(): void
    {
        $this->responseDataStub = '02';
        $this->command = new Command(new CommandID('02'));
        $this->createServiceMock();
        $this->controller = new Controller($this->service);
        $expected = '{"success":true,"event":{"id":"02","description":"RebootController","data":null}}';

        $this->assertSame($expected, $this->controller->rebootModule());
    }
}
