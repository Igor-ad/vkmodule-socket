<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use Autodoctor\ModuleSocket\Exceptions\ExceptionHandler;
use ErrorException;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

#[CoversClass(ExceptionHandler::class)]
class ExceptionHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $handler = new ExceptionHandler(true);

        $this->assertInstanceOf(ExceptionHandler::class, $handler);
    }

    public function testHandleErrorThrowsErrorException(): void
    {
        $handler = new ExceptionHandler(true);

        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage('unit probe');

        $handler->handleError(E_USER_WARNING, 'unit probe', __FILE__, __LINE__);
    }

    /**
     * @return array<string, array{0: Throwable, 1: int}>
     */
    public static function httpStatusDataProvider(): array
    {
        return [
            'invalid_argument' => [new InvalidArgumentException('bad'), 400],
            'runtime' => [new RuntimeException('down'), 503],
            'generic' => [new \Exception('oops'), 500],
            'code_zero_uses_mapped_status' => [new \Exception('x', 0), 500],
        ];
    }

    #[DataProvider('httpStatusDataProvider')]
    public function testGetHttpStatusCodeMapping(Throwable $exception, int $expectedStatus): void
    {
        $handler = new ExceptionHandler(false);
        $method = new \ReflectionMethod(ExceptionHandler::class, 'getHttpStatusCode');
        $method->setAccessible(true);

        $this->assertSame($expectedStatus, $method->invoke($handler, $exception));
    }

    public function testReportLogsAndWritesJsonForApiMode(): void
    {
        $handler = new ExceptionHandler(false);
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('error')
            ->with(
                $this->stringContains('RuntimeException: api probe'),
                $this->arrayHasKey('exception_trace'),
            );
        $handler->setLogger($logger);

        ob_start();
        $handler->report(new RuntimeException('api probe'));
        $body = (string) ob_get_clean();

        $this->assertJson($body);
        $decoded = json_decode($body, true);
        $this->assertIsArray($decoded);
        $this->assertSame('api probe', $decoded['error']);
        $this->assertSame(503, $decoded['code']);
    }

    #[RunInSeparateProcess]
    public function testRegisterInstallsExceptionAndErrorHandlers(): void
    {
        $previousExc = set_exception_handler(null);
        $previousErr = set_error_handler(null);
        try {
            $handler = new ExceptionHandler(true);
            $handler->setLogger($this->createMock(LoggerInterface::class));
            $handler->register();

            $installedExc = set_exception_handler($previousExc);
            $this->assertSame([$handler, 'handle'], $installedExc);

            $installedErr = set_error_handler($previousErr);
            $this->assertSame([$handler, 'handleError'], $installedErr);
        } finally {
            set_exception_handler($previousExc);
            set_error_handler($previousErr);
        }
    }
}
