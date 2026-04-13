<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\CliConsoleCommand;
use Autodoctor\ModuleSocket\Logger\Logger;
use Autodoctor\ModuleSocket\Services\CliService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Tests\Support\UsesLocalTestTcpServer;

#[CoversClass(CliConsoleCommand::class)]
class CliConsoleCommandTest extends TestCase
{
    use UsesLocalTestTcpServer;

    public function testLoggerInitReturnsCliLogger(): void
    {
        $command = new class (CliService::class) extends CliConsoleCommand {
            public function exposeLogger(): LoggerInterface
            {
                return $this->loggerInit();
            }
        };

        $this->assertInstanceOf(Logger::class, $command->exposeLogger());
    }

    public function testLogMessageConstants(): void
    {
        $this->assertSame('Start', CliConsoleCommand::START_MSG);
        $this->assertSame('End', CliConsoleCommand::END_MSG);
    }

    public function testHandleConnectionAgainstLocalTestServerReturnsZero(): void
    {
        $port = $this->ensureLocalTestTcpServerListening('01');
        $command = new CliConsoleCommand(CliService::class);
        $query = '{"module":{"host":"127.0.0.1","port":' . $port . ',"type":"Socket-1"}}';

        $this->assertSame(0, $command->handle('connection', $query));
    }
}