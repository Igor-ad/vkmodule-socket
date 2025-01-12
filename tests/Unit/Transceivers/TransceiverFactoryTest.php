<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Connectors\HttpConnector;
use Autodoctor\ModuleSocket\Transceivers\HttpTransceiver;
use Autodoctor\ModuleSocket\Transceivers\TcpTransceiver;
use Autodoctor\ModuleSocket\Transceivers\TransceiverFactory;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TransceiverFactory::class)]
class TransceiverFactoryTest extends TransceiverInit
{
    public function testTransceiverInit(): void
    {
        $this->transceiver = TransceiverFactory::transceiverInit($this->connectorStub, '01');

        $this->assertInstanceOf(TcpTransceiver::class, $this->transceiver);

        $connectorStub = new HttpConnector('google.com');
        $this->transceiver = TransceiverFactory::transceiverInit($connectorStub);

        $this->assertInstanceOf(HttpTransceiver::class, $this->transceiver);
    }
}
