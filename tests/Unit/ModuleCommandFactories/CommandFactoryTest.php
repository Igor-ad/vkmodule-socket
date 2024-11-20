<?php

declare(strict_types=1);

namespace ModuleCommandFactories;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ModuleCommandFactories\CommandFactory;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\TestCase;

class CommandFactoryTest extends TestCase
{
    public function testInstance(): void
    {
        $factory = CommandFactory::instance([]);
        $this->assertInstanceOf(CommandFactory::class, $factory);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testMake(): void
    {
        $request = [
            'command' => [
                'id' => '21',
                'data' => [
                    'input' => [
                        'inputNumber' => 0,
                    ],
                ],
            ]
        ];
        $command = CommandFactory::instance($request)->make();
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            new InputStatus(
                getValue($request, 'command.data.input.inputNumber'),
            ));
        $this->assertTrue($command->isEqual($anotherCommand));

        $request = [
            'command' => [
                'id' => '20',
                'data' => [
                    'input' => [
                        'inputNumber' => 0,
                        'action' => 1,
                        'antiBounce' => 5,
                    ],
                ],
            ]
        ];
        $command = CommandFactory::instance($request)->make();
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            new Input(
                getValue($request, 'command.data.input.inputNumber'),
                getValue($request, 'command.data.input.action'),
                getValue($request, 'command.data.input.antiBounce'),
            ));
        $this->assertTrue($command->isEqual($anotherCommand));

        $request = [
            'command' => [
                'id' => '43',
                'data' => [
                    'relay' => [
                        'relayNumber' => 0,
                        'action' => 1,
                        'interval' => 20,
                    ],
                ],
            ]
        ];
        $command = CommandFactory::instance($request)->make();
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            new Relay(
                getValue($request, 'command.data.relay.relayNumber'),
                getValue($request, 'command.data.relay.action'),
                getValue($request, 'command.data.relay.interval'),
            ));
        $this->assertTrue($command->isEqual($anotherCommand));

        $request = [
            'command' => [
                'id' => '25',
                'data' => [
                    'relayGroup' => [
                        'relayGroupAction' => 'ffff',
                    ],
                ],
            ]
        ];
        $command = CommandFactory::instance($request)->make();
        $anotherCommand = new Command(
            new CommandID(getValue($request, 'command.id')),
            new RelayGroup(
                getValue($request, 'command.data.relayGroup.relayGroupAction'),
            ));
        $this->assertTrue($command->isEqual($anotherCommand));
    }

    public function test__construct(): void
    {
        $factory = new CommandFactory([]);
        $this->assertInstanceOf(CommandFactory::class, $factory);
    }
}
