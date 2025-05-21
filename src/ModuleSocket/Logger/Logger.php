<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Logger;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\FileProcessor;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

class Logger extends AbstractLogger
{
    use LogFormatter;

    public function __construct(
        protected string $logFile,
    ) {
    }

    /**
     * @throws ModuleException
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!$this->isValidLevel($level)) {
            throw new InvalidArgumentException('This logging level is not available.');
        }
        FileProcessor::putContent(
            $this->logFile,
            $this->toString($level, $message, $context),
            FILE_APPEND
        );
    }

    private function isValidLevel(string $level): bool
    {
        return in_array($level, $this->logLevelToArray(), true);
    }

    private function logLevelToArray(): array
    {
        $logLevel = new LogLevel();
        $reflection = new \ReflectionClass($logLevel);

        return $reflection->getConstants();
    }
}
