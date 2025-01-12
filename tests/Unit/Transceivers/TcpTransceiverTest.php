<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Exceptions\TransmitException;
use Autodoctor\ModuleSocket\Transceivers\TcpTransceiver;
use PHPUnit\Framework\Attributes\CoversClass;
use ReflectionClass;
use ReflectionException;

#[CoversClass(TcpTransceiver::class)]
class TcpTransceiverTest extends TransceiverInit
{
    public const STUB_STEAM_DATA = '22';

    protected function setUp(): void
    {
        parent::setUp();

        $this->transceiver = new TcpTransceiver(
            $this->connectorStub,
            chr(hexdec(self::STUB_STEAM_DATA)),
            1
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSetStreamData(): void
    {
        $expected = chr(hexdec(self::STUB_STEAM_DATA));
        $this->transceiver->setStreamData($expected);
        $reflectionTransceiver = new ReflectionClass($this->transceiver);
        $streamData = $reflectionTransceiver->getProperty('streamData')->getValue($this->transceiver);

        $this->assertSame($expected, $streamData);
    }

    public function testProcessing(): void
    {
        $actualData = $this->transceiver->processing();
        $this->assertSame(self::STUB_STEAM_DATA, $actualData);

        $rebootCmdExpected = '02';
        $streamData = chr(hexdec($rebootCmdExpected));
        $this->transceiver->setStreamData($streamData);

        $this->assertSame($rebootCmdExpected, $this->transceiver->processing());
    }

    public function testProcessingException(): void
    {
        $this->transceiver->setStreamData('');

        $this->expectException(TransmitException::class);
        $this->transceiver->processing();
    }
}
