<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Connectors\FileConnector;
use Autodoctor\ModuleSocket\Exceptions\TransmitException;
use Autodoctor\ModuleSocket\Transceivers\TcpTransceiver;
use PHPUnit\Framework\Attributes\CoversClass;
use ReflectionClass;
use ReflectionException;

#[CoversClass(TcpTransceiver::class)]
class TcpTransceiverTest extends TransceiverInit
{
    public const EXPECTED_DATA = '22';

    /**
     * @throws ReflectionException
     */
    public function testSetStreamData(): void
    {
        $expected = chr(hexdec(self::EXPECTED_DATA));
        $this->transceiver->setStreamData($expected);
        $reflectionTransceiver = new ReflectionClass($this->transceiver);
        $streamData = $reflectionTransceiver->getProperty('streamData')->getValue($this->transceiver);

        $this->assertSame($expected, $streamData);
    }

    public function testGetStreamContent(): void
    {
        $streamData = chr(hexdec(self::EXPECTED_DATA));
        $this->transceiver->write($streamData);

        if ($this->connectorStub instanceof FileConnector) {
            rewind($this->connectorStub->getConnector());
        }

        $actualData = $this->transceiver->getStreamContent();

        $this->assertSame(self::EXPECTED_DATA, $actualData);
    }

    public function testRebootGetStreamContent(): void
    {
        $rebootCmdExpected = '02';
        $streamData = chr(hexdec($rebootCmdExpected));
        $this->transceiver->setStreamData($streamData);

        $this->assertSame($rebootCmdExpected, $this->transceiver->getStreamContent());
    }

    public function testGetStreamContentException(): void
    {
        $this->transceiver->setStreamData('');

        $this->expectException(TransmitException::class);
        $this->transceiver->getStreamContent();
    }
}
