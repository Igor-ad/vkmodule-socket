<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Clients\TcpConnector;
use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\FileConnector;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Transceivers\TcpTransceiver;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Tests\LocalSocketServerInit;

#[CoversNothing]
class TransceiverInit extends TestCase
{
    protected Connector $connectorStub;
    protected Transceiver $transceiver;
    protected string $fileName;

    /**
     * @return void
     * @throws ModuleException
     * FileConnector is used
     */
    public function setUp(): void
    {
        $this->fileName = tempnam('/tmp', '_');
        chmod($this->fileName, 0755);
        $this->connectorStub = new FileConnector($this->fileName, 'wb+');
        $this->transceiver = new TcpTransceiver($this->connectorStub);
    }

    /**
     * @return void
     * TcpConnector is used
     * class TransceiverInit extends LocalSocketServerInit
     */
    public function setUp_Tcp(): void
    {
        parent::setUp();

        $this->connectorStub = new TcpConnector('localhost', $this->port, 5);
        $this->transceiver = new TcpTransceiver($this->connectorStub);
    }

    protected function tearDown(): void
    {
        unlink($this->fileName);
    }
}
