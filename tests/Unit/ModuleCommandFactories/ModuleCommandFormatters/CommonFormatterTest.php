<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\CommonFormatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommonFormatter::class)]
class CommonFormatterTest extends TestCase
{
    public function testGetModuleUid(): void
    {
        $command = CommonFormatter::getModuleUid();

        $this->assertTrue($command->isEqual(new Command(new CommandID('04'))));
    }

    public function testRebootModule(): void
    {
        $command = CommonFormatter::rebootModule();

        $this->assertTrue($command->isEqual(new Command(new CommandID('02'))));
    }

    public function testGetFirmware(): void
    {
        $command = CommonFormatter::getFirmware();

        $this->assertTrue($command->isEqual(new Command(new CommandID('03'))));
    }

    public function testCheckConnect(): void
    {
        $command = CommonFormatter::checkConnect();

        $this->assertTrue($command->isEqual(new Command(new CommandID('01'))));
    }
}
