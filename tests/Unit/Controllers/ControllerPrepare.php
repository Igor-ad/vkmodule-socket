<?php declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Services\Service;
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

    protected function createServiceMock(): void
    {
        $this->service = $this->getMockBuilder(Service::class)
            ->onlyMethods(['getResponse'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->response = new Response($this->responseDataStub);

        $this->service->expects($this->once())
            ->method('getResponse')
            ->with($this->command)
            ->willReturn($this->response);
    }
}
