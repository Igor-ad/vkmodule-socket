<?php

declare(strict_types=1);

namespace Tests\Unit\ModuleCommandFactories;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\CommandFactory;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandFactory::class)]
class CommandFactoryTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
    }

    public function testMakeId_01(): void
    {
        $request = [
            'command' => [
                'id' => '21',
                'data' => [
                    CommandDataRootKey::Input->value => [
                        'inputNumber' => 0,
                    ],
                ],
            ]
        ];
        $command = CommandFactory::make(
            getValue($request, 'command.id'),
            getValue($request, 'command.data'),
            $this->validator,
        );
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            new InputStatus(
                getValue($request, 'command.data.input.inputNumber'),
            )
        );

        $this->assertTrue($command->isEqual($anotherCommand));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testMakeId_20(): void
    {
        $request = [
            'command' => [
                'id' => '20',
                'data' => [
                    CommandDataRootKey::Input->value => [
                        'inputNumber' => 0,
                        'action' => 1,
                        'antiBounce' => 5,
                    ],
                ],
            ]
        ];
        $command = CommandFactory::make(
            getValue($request, 'command.id'),
            getValue($request, 'command.data'),
            $this->validator,
        );
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            Input::fromArray([
                'inputNumber' => getValue($request, 'command.data.input.inputNumber'),
                'action' => getValue($request, 'command.data.input.action'),
                'antiBounce' => getValue($request, 'command.data.input.antiBounce'),
            ])
        );

        $this->assertTrue($command->isEqual($anotherCommand));

    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testMakeId_43(): void
    {
        $request = [
            'command' => [
                'id' => '43',
                'data' => [
                    CommandDataRootKey::Relay->value => [
                        'relayNumber' => 0,
                        'action' => 1,
                        'interval' => 20,
                    ],
                ],
            ]
        ];
        $command = CommandFactory::make(
            getValue($request, 'command.id'),
            getValue($request, 'command.data'),
            $this->validator,
        );
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            Relay::fromArray([
                'relayNumber' => getValue($request, 'command.data.relay.relayNumber'),
                'action' => getValue($request, 'command.data.relay.action'),
                'interval' => getValue($request, 'command.data.relay.interval'),
            ])
        );

        $this->assertTrue($command->isEqual($anotherCommand));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testMakeId_25(): void
    {
        $request = [
            'command' => [
                'id' => '25',
                'data' => [
                    CommandDataRootKey::RelayGroup->value => [
                        'relayGroupAction' => 'ffff',
                    ],
                ],
            ]
        ];
        $command = CommandFactory::make(
            getValue($request, 'command.id'),
            getValue($request, 'command.data'),
            $this->validator,
        );
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            RelayGroup::fromArray([
                'relayGroupAction' => getValue($request, 'command.data.relayGroup.relayGroupAction'),
            ])
        );

        $this->assertTrue($command->isEqual($anotherCommand));
    }
}
