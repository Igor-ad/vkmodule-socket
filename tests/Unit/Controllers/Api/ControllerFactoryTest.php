<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\Api\Controller;
use Autodoctor\ModuleSocket\Controllers\Api\ControllerFactory;
use Autodoctor\ModuleSocket\Controllers\Api\Socket1Controller;
use Autodoctor\ModuleSocket\Controllers\Api\Socket2Controller;
use Autodoctor\ModuleSocket\Controllers\Api\Socket3Controller;
use Autodoctor\ModuleSocket\Controllers\Api\Socket4Controller;
use Autodoctor\ModuleSocket\Controllers\Api\Socket5Controller;
use Autodoctor\ModuleSocket\Controllers\Api\SocketGiantController;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Controllers\ControllerInit;

#[CoversClass(ControllerFactory::class)]
class ControllerFactoryTest extends ControllerInit
{
    public function testMake(): void
    {
        $controller = ControllerFactory::make($this->service, 'Socket-1');

        $this->assertInstanceOf(Socket1Controller::class, $controller);

        $controller = ControllerFactory::make($this->service, 'Socket-2');

        $this->assertInstanceOf(Socket2Controller::class, $controller);

        $controller = ControllerFactory::make($this->service, 'Socket-3');

        $this->assertInstanceOf(Socket3Controller::class, $controller);

        $controller = ControllerFactory::make($this->service, 'Socket-4');

        $this->assertInstanceOf(Socket4Controller::class, $controller);

        $controller = ControllerFactory::make($this->service, 'Socket-5');

        $this->assertInstanceOf(Socket5Controller::class, $controller);

        $controller = ControllerFactory::make($this->service, 'Socket-Giant');

        $this->assertInstanceOf(SocketGiantController::class, $controller);

        $controller = ControllerFactory::make($this->service, '');

        $this->assertInstanceOf(Controller::class, $controller);
    }
}
