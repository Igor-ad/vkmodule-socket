<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Services\CliService;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Log\LoggerInterface;

#[CoversClass(CliService::class)]
class CliServiceTest extends AbstractServiceTest
{
    public function testGetResponse(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
        $apiService = new CliService($this->transceiver, $validator);
        $this->command = new Command(new CommandID('01'));

        $this->assertInstanceOf(Response::class, $apiService->getResponse($this->command));
    }

    public function testGetResponseInvokesLoggerDebugWhenLoggerSet(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
        $service = new CliService($this->transceiver, $validator);
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('debug')
            ->with(
                $this->callback(static fn (string $message): bool => str_starts_with($message, 'Response: ')),
                $this->isType('array'),
            );
        $service->setLogger($logger);

        $service->getResponse(new Command(new CommandID('01')));
    }
}
