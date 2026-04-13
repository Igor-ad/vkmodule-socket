<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Services\ApiService;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ApiService::class)]
class ApiServiceTest extends AbstractServiceTest
{
    public function testGetResponse(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
        $apiService = new ApiService($this->transceiver, $validator);
        $this->command = new Command(new CommandID('01'));

        $this->assertInstanceOf(Response::class, $apiService->getResponse($this->command));
    }
}
