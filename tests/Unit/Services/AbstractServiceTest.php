<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Services\AbstractService;
use Autodoctor\ModuleSocket\Services\Service;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Transceivers\TransceiverInit;

#[CoversClass(AbstractService::class)]
class AbstractServiceTest extends TransceiverInit
{
    protected Service $service;
    protected Response $response;
    protected Command $command;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->getMockBuilder(Service::class)
            ->onlyMethods(['getResponse', 'getValidator'])
            ->disableOriginalConstructor()
            ->getMock();

        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));
        $this->service->method('getValidator')->willReturn($validator);
        $this->response = new Response('01');
        $this->command = new Command(new CommandID('01'));
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Service::class, $this->service);
    }

    public function testGetResponse(): void
    {
        $this->service->expects($this->once())
            ->method('getResponse')
            ->with($this->command)
            ->willReturn($this->response);

        $this->assertInstanceOf(Response::class, $this->service->getResponse($this->command));
    }
}
