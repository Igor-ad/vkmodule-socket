<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Services\CliService;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CliService::class)]
class CliServiceTest extends AbstractServiceTest
{
        public function testGetResponse(): void
    {
        $apiService = new CliService($this->transceiver);
        $this->command = new Command(new CommandID('01'));

        $this->assertInstanceOf(Response::class, $apiService->getResponse($this->command));
    }
}
