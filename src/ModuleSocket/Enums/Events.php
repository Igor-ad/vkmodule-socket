<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Events: string
{
    // Socket-1
    case SOCKET1_INPUT_CHANGE_STATUS = '31';

    // Socket-2, Socket-2W, Socket-4, Socket-5, Socket-Giant
    case INPUT_CHANGE_STATUS = '21';

    public static function events(): array
    {
        return array_merge(
            Commands::commands(),
            array_column(self::cases(), 'value')
        );
    }

    public static function description(string $commandId, string $eventId): string
    {
        if ($commandId === '21' && $eventId === '20') {
            return strtolower(Commands::from('21')->name);
        }
        if ($commandId === '31' && $eventId === '30') {
            return strtolower(Commands::from('31')->name);
        }
        return Commands::description($eventId);
    }
}
