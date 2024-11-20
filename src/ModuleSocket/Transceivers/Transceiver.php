<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

interface Transceiver
{
    public const ATTEMPT = 3;
    public const SLEEP_INTERVAL = 3;
}
