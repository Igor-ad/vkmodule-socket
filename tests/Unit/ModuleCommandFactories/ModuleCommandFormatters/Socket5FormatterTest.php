<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket5Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket5Formatter::class)]
class Socket5FormatterTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

    public function testGetAllStatus(): void
    {
        $command = Socket5Formatter::getAllStatus();

        $this->assertTrue($command->isEqual(new Command(new CommandID('23'))));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testInputSetup(): void
    {
        $input = Input::fromArray(['inputNumber' => 0, 'action' => 1, 'antiBounce' => 5]);
        $command = Socket5Formatter::inputSetup($input);

        $this->assertTrue($command->isEqual(new Command(new CommandID('20'), $input)));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateInputAction(10);
    }

    public function testGetInputStatus(): void
    {
        $inputStatus = new InputStatus(0);
        $command = Socket5Formatter::getInputStatus($inputStatus);

        $this->assertTrue($command->isEqual(new Command(new CommandID('21'), $inputStatus)));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testRelayAction(): void
    {
        $relay = Relay::fromArray(['relayNumber' => 0, 'action' => 1, 'interval' => 10]);
        $command = Socket5Formatter::relayAction($relay);

        $this->assertTrue($command->isEqual(new Command(new CommandID('22'), $relay)));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateRelayAction(10);
    }
}
