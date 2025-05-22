<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum ModuleTypes: string
{
    case Socket1 = 'Socket-1';
    case Socket2 = 'Socket-2';
    case Socket3 = 'Socket-3';
    case Socket4 = 'Socket-4';
    case Socket5 = 'Socket-5';
    case SocketGiant = 'Socket-Giant';

    public static function values(): array
    {
        return array_map(fn ($case): string => $case->value, self::cases());
    }

    public static function validateType(string $type): bool
    {
        return in_array($type, self::values());
    }
}
