<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

/**
 * HTTP transport is not wired into the public CLI/API path yet; {@see TransceiverFactory} still selects this class
 * for {@see \Autodoctor\ModuleSocket\Connectors\Clients\HttpConnector}. Stub implementation — excluded from coverage.
 *
 * @codeCoverageIgnore
 */
class HttpTransceiver extends AbstractTransceiver
{
    public function getStreamContent(): string
    {
        $this->write($this->streamData);

        return $this->read();
    }

    public function read(int $length = 128): string|false
    {
        return false;
    }

    public function write(string $data, ?int $length = null): int|false
    {
        return false;
    }
}
