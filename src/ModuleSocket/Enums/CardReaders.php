<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

class CardReaders
{
    public const EM_MARINE_CARD = Commands::EmMarineCard->value;
    public const MIFARE_CARD = Commands::MifareCard->value;
    public const MANAGING_ONLINE_STATUS = Commands::ManagingOnlineStatus->value;
    public const MANAGING_OFFLINE_STATUS = Commands::ManagingOfflineStatus->value;
    public const MANAGING_RESPONSE_WAITING = Commands::ManagingResponseWaiting->value;
    public const MANAGING_RESPONSE_STATUS = Commands::ManagingResponseStatus->value;
}
