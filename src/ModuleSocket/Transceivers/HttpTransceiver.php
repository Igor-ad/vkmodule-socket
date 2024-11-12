<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

class HttpTransceiver extends AbstractTransceiver
{
    public function read(int $length = 128): string|false
    {
        // TODO: Implement read() method.
    }

    public function write(string $data, ?int $length = null): int|false
    {
        // TODO: Implement write() method.
    }

    public function processing(): string
    {
        $this->write($this->streamData);

        return $this->read();
    }

    public function setStreamData(string $streamData): void
    {
        $this->streamData = $streamData;
    }
}
