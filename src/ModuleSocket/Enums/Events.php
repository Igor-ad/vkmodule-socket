<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Events: string
{
    // Socket-1
    case Socket1GetInput = '30';
    case Socket1InputStatusChanged = '31';

    // Socket-2, Socket-2W, Socket-4, Socket-5, Socket-Giant
    case GetInput = '20';
    case InputStatusChanged = '21';

    public static function events(): array
    {
        return Commands::commands();
    }

    public static function description(string $eventId): string
    {
        return match ($eventId) {
            '20' => Events::from('20')->name,
            '30' => Events::from('30')->name,
            default => Commands::description($eventId),
        };
    }

    public static function descriptionAutoGenerateEvent(string $eventId): string
    {
        return match ($eventId) {
            '21' => Events::from('21')->name,
            '31' => Events::from('31')->name,
            default => Commands::description($eventId),
        };
    }
}
