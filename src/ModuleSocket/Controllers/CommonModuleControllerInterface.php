<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

interface CommonModuleControllerInterface
{
    public function checkConnection(): string;

    public function getModuleFirmware(): string;

    public function getModuleUID(): string;

    public function rebootModule(): string;
}
