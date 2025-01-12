<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Autodoctor\ModuleSocket\Controllers\AbstractController;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Services\Service;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
abstract class ControllerInit extends TestCase
{
    protected ControllerInterface $controller;
    protected Service $service;

    public function setUp(): void
    {
        $this->service = $this->getMockBuilder(Service::class)
            ->onlyMethods(['getResponse'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new class ($this->service) extends AbstractController {
        };
    }
}
