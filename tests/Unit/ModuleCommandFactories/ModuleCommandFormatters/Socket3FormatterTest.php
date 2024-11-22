<?php declare(strict_types=1);

namespace ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket3Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket3Formatter::class)]
class Socket3FormatterTest extends TestCase
{

    public function testGetAllStatus(): void
    {
        $command = Socket3Formatter::getAllStatus();
        $this->assertTrue($command->isEqual(new Command(new CommandID('44'))));
    }

    public function testGetSensor0()
    {
        $command = Socket3Formatter::getSensor0();
        $this->assertTrue($command->isEqual(new Command(new CommandID('41'))));
    }

    public function testGetSensor1(): void
    {
        $command = Socket3Formatter::getSensor1();
        $this->assertTrue($command->isEqual(new Command(new CommandID('42'))));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $relay = new Relay(0, 1, 10);
        $command = Socket3Formatter::relayAction($relay);
        $this->assertTrue($command->isEqual(new Command(new CommandID('43'), $relay)));
        $this->expectException(InvalidInputParameterException::class);
        new Relay(0, 10, 512);
    }
}
