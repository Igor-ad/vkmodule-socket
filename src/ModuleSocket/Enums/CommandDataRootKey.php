<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum CommandDataRootKey: string
{
    case Input = 'input';

    case Relay = 'relay';

    case RelayGroup = 'relayGroup';
}
