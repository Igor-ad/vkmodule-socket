<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

class CardReaders
{
    const EM_MARINE_CARD = Commands::EmMarineCard->value;
    const MIFARE_CARD = Commands::MifareCard->value;
    const MANAGING_ONLINE_STATUS = Commands::ManagingOnlineStatus->value;
    const MANAGING_OFFLINE_STATUS = Commands::ManagingOfflineStatus->value;
    const MANAGING_RESPONSE_WAITING = Commands::ManagingResponseWaiting->value;
    const MANAGING_RESPONSE_STATUS = Commands::ManagingResponseStatus->value;
}
