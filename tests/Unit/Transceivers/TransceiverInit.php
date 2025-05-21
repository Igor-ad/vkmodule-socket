<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\Connectors\FileConnector;
use Autodoctor\ModuleSocket\Connectors\TcpConnector;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\Transceivers\TcpTransceiver;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class TransceiverInit extends TestCase
{
    protected Connector $connectorStub;
    protected Transceiver $transceiver;
    /**
     * @return void
     * @throws ModuleException
     * FileConnector is used
     */
    protected function setUp(): void
    {
        $this->fileName = tempnam('/tmp', '_');
        chmod($this->fileName, 0755);
        $this->connectorStub = new FileConnector($this->fileName, 'wb+');
        $this->transceiver = new TcpTransceiver($this->connectorStub);
    }

    protected string $fileName;

    /**
     * @return void
     * TcpConnector is used
     */
    public function setUp_Tcp(): void
    {
        $command = Files::TcpServer->getPath() . " >/dev/null 2>&1 &";
        exec($command);
        usleep(400 * 1000);

        $this->connectorStub = new TcpConnector('localhost', 9761);
        $this->transceiver = new TcpTransceiver($this->connectorStub);
    }

    protected function tearDown(): void
    {
        unlink($this->fileName);
    }
}
