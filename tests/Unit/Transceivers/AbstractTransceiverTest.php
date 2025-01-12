<?php

declare(strict_types=1);

namespace Tests\Unit\Transceivers;

use Autodoctor\ModuleSocket\Transceivers\AbstractTransceiver;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use PHPUnit\Framework\Attributes\CoversClass;
use ReflectionException;
use ReflectionMethod;

#[CoversClass(AbstractTransceiver::class)]
class AbstractTransceiverTest extends TransceiverInit
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->transceiver = new class($this->connectorStub) extends AbstractTransceiver {
            public function read(int $length = 32): string|false {}

            public function write(string $data, ?int $length = null): int|false {}

            public function processing(): string {}

            public function setStreamData(string $streamData): void {}
        };
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Transceiver::class, $this->transceiver);
    }

    /**
     * @throws ReflectionException
     */
    public function testTry(): void
    {
        $reflectionTry = new ReflectionMethod($this->transceiver, 'try');
        $result = $reflectionTry->invoke($this->transceiver, 1, 1);

        $this->assertTrue(!$result);

        $result = $reflectionTry->invoke($this->transceiver, 2, 1);

        $this->assertTrue($result);
    }
}
