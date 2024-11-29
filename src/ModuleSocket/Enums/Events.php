<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Events: string
{
    // Socket-1
    case Socket1InputStatusChanged = '31';

    // Socket-2, Socket-2W, Socket-4, Socket-5, Socket-Giant
    case InputStatusChanged = '21';

    public static function events(): array
    {
        return Commands::commands();
    }

    public static function description(string $commandId, string $eventId): string
    {
        if ($commandId === '21' && $eventId === '20') {
            return Events::from('21')->name;
        }
        if ($commandId === '31' && $eventId === '30') {
            return Events::from('31')->name;
        }
        return Commands::description($eventId);
    }
}
