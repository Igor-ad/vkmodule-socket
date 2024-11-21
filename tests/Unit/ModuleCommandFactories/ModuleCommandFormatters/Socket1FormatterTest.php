<?php declare(strict_types=1);

namespace ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket1Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket1Formatter::class)]
class Socket1FormatterTest extends TestCase
{

    public function testGetAllStatus()
    {
        $command = Socket1Formatter::getAllStatus();
        $this->assertTrue($command->isEqual(new Command(new CommandID('32'))));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup()
    {
        $input = new Input(0, 1, 5);
        $command = Socket1Formatter::inputSetup($input);
        $this->assertTrue($command->isEqual(new Command(new CommandID('30'), $input)));
    }

    public function testGetInputStatus()
    {
        $inputStatus = new InputStatus(0);
        $command = Socket1Formatter::getInputStatus($inputStatus);
        $this->assertTrue($command->isEqual(new Command(new CommandID('31'), $inputStatus)));

    }
}
