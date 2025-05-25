<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use Autodoctor\ModuleSocket\Exceptions\ExceptionHandler;
use PHPUnit\Framework\TestCase;

class ExceptionHandlerTest extends TestCase
{

    public function test__construct(): void
    {
        $handler = new ExceptionHandler(true);

        $this->assertInstanceOf(ExceptionHandler::class, $handler);
    }

    public function testHandle(): void {}

    public function testHandleError(): void {}

    public function testRegister(): void {}
}
