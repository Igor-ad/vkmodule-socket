<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\SocketGiantFormatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SocketGiantFormatter::class)]
class SocketGiantFormatterTest extends TestCase
{
    public function testGetAllStatus(): void
    {
        $command = SocketGiantFormatter::getAllStatus();

        $this->assertTrue($command->isEqual(new Command(new CommandID('23'))));
    }

    public function testGetInputStatus(): void
    {
        $inputStatus = new InputStatus(0);
        $command = SocketGiantFormatter::getInputStatus($inputStatus);

        $this->assertTrue($command->isEqual(new Command(new CommandID('21'), $inputStatus)));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $relay = new Relay(0, 1, 10);
        $command = SocketGiantFormatter::relayAction($relay);

        $this->assertTrue($command->isEqual(new Command(new CommandID('22'), $relay)));

        $this->expectException(InvalidInputParameterException::class);
        new Relay(0, 10, 250);
    }

    public function testRelayGroupAction(): void
    {
        $relyGroup = new RelayGroup('ffff');
        $command = SocketGiantFormatter::relayGroupAction($relyGroup);

        $this->assertTrue($command->isEqual(new Command(new CommandID('25'), $relyGroup)));

        $this->expectException(InvalidInputParameterException::class);
        new RelayGroup('ffffaa');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testSetupInput(): void
    {
        $input = new Input(0, 1, 5);
        $command = SocketGiantFormatter::setupInput($input);

        $this->assertTrue($command->isEqual(new Command(new CommandID('20'), $input)));

        $this->expectException(InvalidInputParameterException::class);
        new Input(0, 10, 512);
    }
}
