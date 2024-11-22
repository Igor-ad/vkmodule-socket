<?php declare(strict_types=1);

namespace Logger;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\FileProcessor;
use Autodoctor\ModuleSocket\Logger\Logger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;

#[CoversClass(Logger::class)]
class LoggerTest extends TestCase
{
    protected string $logFile = './test.log';
    protected Logger $logger;

    protected function setUp(): void
    {
        $this->logger = new Logger($this->logFile);
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
        $message = 'TEST';
        $this->logger->log('info', $message);

        $this->assertTrue(is_int(strrpos(FileProcessor::getContent($this->logFile), $message)));

        $this->expectException(InvalidArgumentException::class);
        $this->logger->log('unknown', $message);
    }

    protected function tearDown(): void
    {
        unlink($this->logFile);
    }
}
