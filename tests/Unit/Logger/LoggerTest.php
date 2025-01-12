<?php

declare(strict_types=1);

namespace Tests\Unit\Logger;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\FileProcessor;
use Autodoctor\ModuleSocket\Logger\Logger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;

#[CoversClass(Logger::class)]
class LoggerTest extends TestCase
{
    protected Logger $logger;
    protected string $testLogFile = __DIR__ . '/../../log/socket_test.log';

    protected function setUp(): void
    {
        $this->logger = new Logger($this->testLogFile);
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Logger::class, $this->logger);
    }

    /**
     * @throws ModuleException
     */
    public function testLog(): void
    {
        $expectedMessage = 'TEST';
        $expectedLevel = 'info';
        $this->logger->log($expectedLevel, $expectedMessage);

        $this->assertTrue(is_int(strrpos(FileProcessor::getContent($this->testLogFile), $expectedMessage)));
        $this->assertTrue(is_int(strrpos(FileProcessor::getContent($this->testLogFile), $expectedLevel)));

        $this->expectException(InvalidArgumentException::class);
        $this->logger->log('unknown', $expectedMessage);
    }

    protected function tearDown(): void
    {
        unlink($this->testLogFile);
    }
}
