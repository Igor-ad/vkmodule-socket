<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Exceptions;

use ErrorException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class ExceptionHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private bool $isCli;

    public function __construct(bool $isCli)
    {
        $this->isCli = $isCli;
    }

    public function register(): void
    {
        set_exception_handler([$this, 'handle']);
        set_error_handler([$this, 'handleError']);
    }

    public function handle(Throwable $exception): void
    {
        $this->logger->error(
            sprintf(
                '%s: %s in %s:%d',
                get_class($exception),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
            ),
            ['exception_trace' => $exception->getTraceAsString()]
        );

        $this->isCli ? $this->renderCli($exception) : $this->renderApi($exception);

        exit(1);
    }

    /**
     * @throws ErrorException
     */
    public function handleError(int $severity, string $message, string $file, int $line): bool
    {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    private function renderCli(Throwable $exception): void
    {
        fwrite(
            STDERR,
            sprintf(
                "Error: %s in %s:%d\n",
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            )
        );
    }

    private function renderApi(Throwable $exception): void
    {
        header('Content-Type: application/json', true, $this->getHttpStatusCode($exception));
        echo json_encode(
            [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode() ?: 500
            ]
        );
    }

    private function getHttpStatusCode(Throwable $exception): int
    {
        return match (true) {
            $exception instanceof \InvalidArgumentException => 400,
            $exception instanceof \RuntimeException => 503,
            default => 500,
        };
    }
}
