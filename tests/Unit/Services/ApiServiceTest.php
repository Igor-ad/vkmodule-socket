<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Services\ApiService;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ApiService::class)]
class ApiServiceTest extends AbstractServiceTest
{
    public function testGetResponse(): void
    {
        $apiService = new ApiService($this->transceiver);
        $this->command = new Command(new CommandID('01'));

        $this->assertInstanceOf(Response::class, $apiService->getResponse($this->command));
    }
}
