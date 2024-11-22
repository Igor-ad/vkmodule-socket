<?php declare(strict_types=1);

namespace ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket4Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket4Formatter::class)]
class Socket4FormatterTest extends TestCase
{
    public function testGetAllStatus(): void
    {
        $command = Socket4Formatter::getAllStatus();

        $this->assertTrue($command->isEqual(new Command(new CommandID('23'))));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $relay = new Relay(0, 1, 10);
        $command = Socket4Formatter::relayAction($relay);

        $this->assertTrue($command->isEqual(new Command(new CommandID('22'), $relay)));

        $this->expectException(InvalidInputParameterException::class);
        new Relay(0, 10, 512);
    }
}
