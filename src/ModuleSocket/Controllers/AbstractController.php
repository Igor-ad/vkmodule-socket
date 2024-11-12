<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\Services\Service;

abstract class AbstractController implements ControllerInterface
{
    public function __construct(
        protected Service $service,
    ) {}
}
