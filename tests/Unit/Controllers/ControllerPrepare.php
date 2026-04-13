<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Services\Service;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
abstract class ControllerPrepare extends TestCase
{
    protected Command $command;

    protected ControllerInterface $controller;

    protected Service $service;

    protected Response $response;

    protected string $responseDataStub;

    protected Validator $commandValidator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commandValidator = new Validator(
            ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath())
        );
    }

    protected function createServiceMock(): void
    {
        $this->service = $this->getMockBuilder(Service::class)
            ->onlyMethods(['getResponse', 'getValidator'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->response = new Response($this->responseDataStub);

        $this->service->method('getValidator')->willReturn($this->commandValidator);

        $this->service->expects($this->once())
            ->method('getResponse')
            ->with($this->command)
            ->willReturn($this->response);
    }
}
