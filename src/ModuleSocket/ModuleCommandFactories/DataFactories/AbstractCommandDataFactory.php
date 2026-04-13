<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\Configuration\ModuleCommandRegistry;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Validation\ValidatorInterface;

abstract class AbstractCommandDataFactory implements CommandDataFactory
{
    public function __construct(
        protected ?array $commandData,
        protected ValidatorInterface $validator,
    ) {
    }

    public static function getDataFactory(
        ?array $commandData,
        ?string $commandId,
        ValidatorInterface $validator,
    ): CommandDataFactory {
        if (
            is_null($commandId)
            && getByKey(array_keys($commandData ?? []), 0) === CommandDataRootKey::Input->value
        ) {
            return new InputSetupDataFactory($commandData, $validator);
        }
        return match (getByKey(array_keys($commandData ?? []), 0)) {
            CommandDataRootKey::Input->value => (self::resolveCommand($commandId))
                ? new InputStatusDataFactory($commandData, $validator)
                : new InputSetupDataFactory($commandData, $validator),
            CommandDataRootKey::Relay->value => new RelayControlDataFactory($commandData, $validator),
            CommandDataRootKey::RelayGroup->value => new RelayGroupControlDataFactory($commandData, $validator),
            default => new NullCommandDataFactory(),
        };
    }

    private static function resolveCommand(?string $commandId): bool
    {
        return $commandId !== null && ModuleCommandRegistry::isInputStatusCommandId($commandId);
    }
}
