<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Transceivers;

use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Exceptions\TransmitException;

class TcpTransceiver extends AbstractTransceiver
{
    public const ATTEMPT = 5;
    public const SLEEP_INTERVAL = 5;

    /**
     * @throws TransmitException
     */
    public function getStreamContent(): string
    {
        if ($this->streamData === chr(hexdec(Common::Reboot->value))) {
            return Common::Reboot->value;
        }

        $response = $this->read();

        if ($response === false && $this->try($this->attemptsToReceive)) {
            $this->getStreamContent();
        }

        if (!$response) {
            throw new TransmitException('Unable to get data from module.');
        }
        return bin2hex($response);
    }

    public function read(int $length = 32): string|false
    {
        return fread(stream: $this->connector->getConnector(), length: $length);
    }

    public function write(string $data, ?int $length = null): int|false
    {
        return fwrite(stream: $this->connector->getConnector(), data: $data, length: $length);
    }
}
