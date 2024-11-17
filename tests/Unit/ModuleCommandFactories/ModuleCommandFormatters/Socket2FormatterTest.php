<?php

declare(strict_types=1);

namespace ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket2Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\TestCase;

class Socket2FormatterTest extends TestCase
{
    public function testGetAllStatus(): void
    {
        $command = Socket2Formatter::getAllStatus();
        $this->assertTrue($command->isEqual(new Command(new CommandID('23'))));
    }

    public function testGetAnalogInput(): void
    {
        $command = Socket2Formatter::getAnalogInput();
        $this->assertTrue($command->isEqual(new Command(new CommandID('24'))));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup(): void
    {
        $input = new Input(0, 1, 5);
        $command = Socket2Formatter::inputSetup($input);
        $this->assertTrue($command->isEqual(new Command(new CommandID('20'), $input)));
    }

    public function testGetInputStatus(): void
    {
        $inputStatus = new InputStatus(0);
        $command = Socket2Formatter::getInputStatus($inputStatus);
        $this->assertTrue($command->isEqual(new Command(new CommandID('21'), $inputStatus)));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $relay = new Relay(0, 1, 10);
        $command = Socket2Formatter::relayAction($relay);
        $this->assertTrue($command->isEqual(new Command(new CommandID('22'), $relay)));
    }
}
