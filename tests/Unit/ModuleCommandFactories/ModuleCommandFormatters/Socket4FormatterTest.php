<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories\ModuleCommandFormatters;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket4Formatter;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Socket4Formatter::class)]
class Socket4FormatterTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

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
        $relay = Relay::fromArray(['relayNumber' => 0, 'action' => 1, 'interval' => 10]);
        $command = Socket4Formatter::relayAction($relay);

        $this->assertTrue($command->isEqual(new Command(new CommandID('22'), $relay)));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateRelayAction(10);
    }
}
