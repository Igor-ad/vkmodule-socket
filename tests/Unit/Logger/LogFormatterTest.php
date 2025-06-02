<?php

declare(strict_types=1);

namespace Tests\Unit\Logger;

use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Logger\Logger;
use PHPUnit\Framework\TestCase;

class LogFormatterTest extends TestCase
{
    public function testGetExceptionContext(): void
    {
        $testLogFile = Files::TestCliLogFile->getPath();
        $logger = new Logger($testLogFile);
        $e = new \Exception();
        $context = $logger->getExceptionContext($e);

        $this->assertTrue(strrpos($context[0], 'Code:') === 0);
        $this->assertTrue(strrpos($context[1], 'File:') === 0);
        $this->assertTrue(strrpos($context[2], 'Line:') === 0);
        $this->assertTrue(strrpos($context[3], 'Trace:') === 0);
    }
}
