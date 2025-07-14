<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum CardReaders: string
{
    case EmMarineCard = Commands::EmMarineCard->value;
    case MifareCard = Commands::MifareCard->value;
    case ManagingOnlineStatus = Commands::ManagingOnlineStatus->value;
    case ManagingOfflineStatus = Commands::ManagingOfflineStatus->value;
    case ManagingResponseWaiting = Commands::ManagingResponseWaiting->value;
    case ManagingResponseStatus = Commands::ManagingResponseStatus->value;
}
