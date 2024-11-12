<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

interface Transceiver
{
    public const ATTEMPT = 3;
    public const SLEEP_INTERVAL = 3;

    public function read(int $length = 32): string|false;

    public function write(string $data, ?int $length = null): int|false;

    public function processing(): string;

    public function setStreamData(string $streamData): void;
}
