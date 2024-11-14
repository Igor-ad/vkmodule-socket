<?php

declare(strict_types=1);

namespace ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\CommonFormatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\TestCase;

class CommonFormatterTest extends TestCase
{

    public function testGetModuleUid()
    {
        $command = CommonFormatter::getModuleUid();
        $this->assertTrue($command->isEqual(new Command(new CommandID('04'))));
    }

    public function testRebootModule()
    {
        $command = CommonFormatter::rebootModule();
        $this->assertTrue($command->isEqual(new Command(new CommandID('02'))));
    }

    public function testGetFirmware()
    {
        $command = CommonFormatter::getFirmware();
        $this->assertTrue($command->isEqual(new Command(new CommandID('03'))));
    }

    public function testCheckConnect()
    {
        $command = CommonFormatter::checkConnect();
        $this->assertTrue($command->isEqual(new Command(new CommandID('01'))));
    }
}
