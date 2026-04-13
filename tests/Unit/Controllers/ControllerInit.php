<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Controllers\AbstractModuleController;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Services\Service;
use Autodoctor\ModuleSocket\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
abstract class ControllerInit extends TestCase
{
    protected ControllerInterface $controller;

    protected Service $service;

    protected Validator $commandValidator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandValidator = new Validator(
            ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath())
        );

        $this->service = $this->getMockBuilder(Service::class)
            ->onlyMethods(['getResponse', 'getValidator'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->service->method('getValidator')->willReturn($this->commandValidator);

        $this->controller = new class ($this->service) extends AbstractModuleController {
        };
    }
}
