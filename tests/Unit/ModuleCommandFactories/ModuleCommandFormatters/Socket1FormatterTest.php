<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
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
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

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
        $input = Input::fromArray(['inputNumber' => 0, 'action' => 1, 'antiBounce' => 5]);
        $command = Socket1Formatter::inputSetup($input);

        $this->assertTrue($command->isEqual(new Command(new CommandID('30'), $input)));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateInputAction(10);
    }

    public function testGetInputStatus()
    {
        $inputStatus = new InputStatus(0);
        $command = Socket1Formatter::getInputStatus($inputStatus);

        $this->assertTrue($command->isEqual(new Command(new CommandID('31'), $inputStatus)));
    }
}
