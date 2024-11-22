<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;

enum Events: string
{
    // Socket-1
    case SOCKET1_INPUT_STATUS_CHANGED = '31';

    // Socket-2, Socket-2W, Socket-4, Socket-5, Socket-Giant
    case INPUT_STATUS_CHANGED = '21';

    public static function events(): array
    {
        return Commands::commands();
    }

    /**
     * @throws ModuleException
     */
    public static function description(string $commandId, string $eventId): string
    {
        if ($commandId === '21' && $eventId === '20') {
            return strtolower(Events::from('21')->name);
        }
        if ($commandId === '31' && $eventId === '30') {
            return strtolower(Events::from('31')->name);
        }
        return Commands::description($eventId);
    }
}
