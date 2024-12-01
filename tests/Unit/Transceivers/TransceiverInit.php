<?php declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class TransceiverInit extends TestCase
{
    protected Connector $connectorStub;
    protected Transceiver $transceiver;

    public function setUp(): void
    {
        $this->connectorStub = new class() implements Connector {
            public function getConnector() {}
        };
    }
}
