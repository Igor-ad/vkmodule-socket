<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

class CardReaders
{
    const EM_MARINE_CARD = Commands::EM_MARINE_CARD->value;
    const MIFARE_CARD = Commands::MIFARE_CARD->value;
    const MANAGING_ONLINE_STATUS = Commands::MANAGING_ONLINE_STATUS->value;
    const MANAGING_OFFLINE_STATUS = Commands::MANAGING_OFFLINE_STATUS->value;
    const MANAGING_RESPONSE_WAITING = Commands::MANAGING_RESPONSE_WAITING->value;
    const MANAGING_RESPONSE_STATUS = Commands::MANAGING_RESPONSE_STATUS->value;
}
