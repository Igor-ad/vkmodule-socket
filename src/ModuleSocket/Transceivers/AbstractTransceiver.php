<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Connector;

abstract class AbstractTransceiver implements Transceiver
{
    public function __construct(
        protected Connector $connector,
        protected string    $streamData = '',
        public int          $attemptsToReceive = self::ATTEMPT,
    ) {}

    public function read(int $length = 32): string|false
    {
        // TODO: Implement read() method.
    }

    public function write(string $data, ?int $length = null): int|false
    {
        // TODO: Implement write() method.
    }

    public function processing(): string
    {
        // TODO: Implement processing() method.
    }

    public function setStreamData(string $streamData): void
    {
        // TODO: Implement setStream() method.
    }

    protected function try(): bool
    {
        sleep(self::SLEEP_INTERVAL);
        --$this->attemptsToReceive;

        return (bool)$this->attemptsToReceive;
    }
}
