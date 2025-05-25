<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

interface Resolution
{
    public static function getModuleCommands(): array;
    public static function resolveInput(int $inputNumber): bool;
    public static function resolveRelay(int $relayNumber): bool;
}
