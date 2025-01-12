<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\FileConnector;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Transceivers\AbstractTransceiver;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class TransceiverInit extends TestCase
{
    protected Connector $connectorStub;
    protected Transceiver $transceiver;
    protected string $fileName;

    /**
     * @throws ModuleException
     */
    protected function setUp(): void
    {
        $this->fileName = tempnam('/tmp', '_');
        $this->connectorStub = new FileConnector($this->fileName, 'wb+');

        $this->transceiver = new class ($this->connectorStub) extends AbstractTransceiver {
            public function read(int $length = 32): string|false
            {
            }

            public function write(string $data, ?int $length = null): int|false
            {
            }

            public function processing(): string
            {
            }

            public function setStreamData(string $streamData): void
            {
            }
        };
    }

    protected function tearDown(): void
    {
        unlink($this->fileName);
    }
}
