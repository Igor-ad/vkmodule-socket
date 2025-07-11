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
    ) {
    }

    abstract public function read(int $length = 32): string|false;

    abstract public function write(string $data, ?int $length = null): int|false;

    abstract public function getStreamContent(): string;

    public function getStreamData(): string
    {
        return $this->streamData;
    }

    public function setStreamData(string $streamData): void
    {
        $this->streamData = $streamData;
    }

    protected function try(int $attempts = 1, int $interval = self::SLEEP_INTERVAL): bool
    {
        $attempts = $attempts < 0 ? 1 : $attempts;
        sleep($interval);
        --$attempts;

        return (bool)$attempts;
    }
}
