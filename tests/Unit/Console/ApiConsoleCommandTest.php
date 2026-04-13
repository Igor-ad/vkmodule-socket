<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\ApiConsoleCommand;
use Autodoctor\ModuleSocket\Services\ApiService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Tests\Support\UsesLocalTestTcpServer;

#[CoversClass(ApiConsoleCommand::class)]
class ApiConsoleCommandTest extends TestCase
{
    use UsesLocalTestTcpServer;

    public function testLoggerInitReturnsNullLogger(): void
    {
        $command = new class (ApiService::class) extends ApiConsoleCommand {
            public function exposeLogger(): LoggerInterface
            {
                return $this->loggerInit();
            }
        };

        $this->assertInstanceOf(NullLogger::class, $command->exposeLogger());
    }

    public function testHandleConnectionAgainstLocalTestServerReturnsJson(): void
    {
        $port = $this->ensureLocalTestTcpServerListening('01');
        $command = new ApiConsoleCommand(ApiService::class);
        $query = '{"module":{"host":"127.0.0.1","port":' . $port . ',"type":"Socket-1"}}';

        $result = $command->handle('connection', $query);

        $this->assertIsString($result);
        $this->assertStringContainsString('"success":true', $result);
        $this->assertStringContainsString('CheckConnect', $result);
    }
}