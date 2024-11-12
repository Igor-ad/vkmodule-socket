<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Enums\Commands;

abstract class AbstractCommandDataFactory implements CommandDataFactory
{
    public function __construct(
        protected ?array $commandData = [],
    ) {}

    public static function getDataFactory(?array $commandData, ?string $commandId): CommandDataFactory
    {
        if (is_null($commandId)
            && getByKey(array_keys($commandData ?? []), 0) === 'input') {

            return new InputSetupDataFactory($commandData);
        }
        return match (getByKey(array_keys($commandData ?? []), 0)) {
            'input' => (self::resolveCommand($commandId))
                ? new InputStatusDataFactory($commandData)
                : new InputSetupDataFactory($commandData),
            'relay' => new RelayControlDataFactory($commandData),
            'relayGroup' => new RelayGroupControlDataFactory($commandData),
            default => new NullCommandDataFactory(),
        };
    }

    private static function resolveCommand(string $commandId): bool
    {
        return $commandId === Commands::SOCKET1_GET_INPUT->value
            || $commandId === Commands::GET_INPUT->value;
    }
}
