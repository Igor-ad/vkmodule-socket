<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Autodoctor\ModuleSocket\Controllers\ControllerInterface;

class AbstractControllerTest extends ControllerInit
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(ControllerInterface::class, $this->controller);
    }
}
