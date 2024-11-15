<?php

declare(strict_types=1);

namespace ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket5Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\TestCase;

class Socket5FormatterTest extends TestCase
{
    public function testGetAllStatus()
    {
        $command = Socket5Formatter::getAllStatus();
        $this->assertTrue($command->isEqual(new Command(new CommandID('23'))));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup()
    {
        $input = new Input(0, 1, 5);
        $command = Socket5Formatter::inputSetup($input);
        $this->assertTrue($command->isEqual(new Command(new CommandID('20'), $input)));
    }

    public function testGetInputStatus()
    {
        $inputStatus = new InputStatus(0);
        $command = Socket5Formatter::getInputStatus($inputStatus);
        $this->assertTrue($command->isEqual(new Command(new CommandID('21'), $inputStatus)));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction()
    {
        $relay = new Relay(0, 1, 10);
        $command = Socket5Formatter::relayAction($relay);
        $this->assertTrue($command->isEqual(new Command(new CommandID('22'), $relay)));
    }
}
