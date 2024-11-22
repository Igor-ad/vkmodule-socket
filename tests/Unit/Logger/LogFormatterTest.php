<?php declare(strict_types=1);

namespace Logger;

use Autodoctor\ModuleSocket\Logger\LogFormatter;
use Autodoctor\ModuleSocket\Logger\Logger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LogFormatter::class)]
class LogFormatterTest extends TestCase
{
    public function testGetExceptionContext(): void
    {
        $e = new \Exception();
        $logger = new Logger('./test.log');
        $context = $logger->getExceptionContext($e);

        $this->assertTrue(strrpos($context[0], 'Code:') === 0);
        $this->assertTrue(strrpos($context[1], 'File:') === 0);
        $this->assertTrue(strrpos($context[2], 'Line:') === 0);
        $this->assertTrue(strrpos($context[3], 'Trace:') === 0);
    }
}
