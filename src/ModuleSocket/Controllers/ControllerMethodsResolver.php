<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\Configuration\ModuleCommandRegistry;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;

trait ControllerMethodsResolver
{
    /**
     * @throws ModuleException
     */
    protected function resolve(?string $commandId): string
    {
        if ($commandId === null || $commandId === '') {
            throw new ModuleException('Invalid module command ID.');
        }

        $method = ModuleCommandRegistry::controllerMethodForCommandId($commandId);
        if ($method === null) {
            throw new ModuleException('Invalid module command ID.');
        }

        return $method;
    }
}
