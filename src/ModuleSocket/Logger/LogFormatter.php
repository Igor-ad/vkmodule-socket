<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Logger;

trait LogFormatter
{
    protected function toString($level, string $message, array $context = []): string
    {
        $pid = $this->pidToString(getmypid());

        return sprintf(
            '%s | pid: %s | %s: %s%s%s',
            date('Y-m-d H:i:s'),
            $pid,
            $level,
            $message,
            empty($this->contextToString($context)) ? '' :  PHP_EOL . $this->contextToString($context),
            PHP_EOL
        );
    }

    protected function contextToString(array $context): string
    {
        return implode("\n", $context);
    }

    protected function pidToString($pid): string
    {
        return match (true) {
            $pid < 100 => $pid . '   ',
            $pid < 1000 => $pid . '  ',
            $pid < 10000 => $pid . ' ',
            default => (string)$pid,
        };
    }

    public function getExceptionContext(\Throwable $exception): array
    {
        return [
            'Code: ' . $exception->getCode(),
            'File: ' . $exception->getFile(),
            'Line: ' . $exception->getLine(),
            'Trace: ' . $exception->getTraceAsString(),
        ];
    }
}
