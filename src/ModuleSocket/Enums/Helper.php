<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

trait Helper
{
    public static function allowedInput(): array
    {
        return range(static::INPUT_START_NUMBER, static::INPUT_END_NUMBER);
    }

    public static function allowedRelay(): array
    {
        return range(static::RELAY_START_NUMBER, static::RELAY_END_NUMBER);
    }

    public static function resolveInput(int $inputNumber): bool
    {
        return in_array($inputNumber, static::allowedInput(), true);
    }

    public static function resolveRelay(int $relayNumber): bool
    {
        return in_array($relayNumber, static::allowedRelay(), true);
    }

    public static function commands(): array
    {
        return array_column(static::cases(), 'value');
    }

    public static function getModuleCommands(): array
    {
        return array_merge(Common::commands(), static::commands());
    }
}
