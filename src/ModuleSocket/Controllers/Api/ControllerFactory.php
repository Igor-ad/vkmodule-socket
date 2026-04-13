<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use Autodoctor\ModuleSocket\Services\Service;

class ControllerFactory
{
    public static function make(Service $service, string $moduleType): ControllerInterface
    {
        return match ($moduleType) {
            ModuleTypes::Socket1->value => new Socket1Controller($service),
            ModuleTypes::Socket2->value => new Socket2Controller($service),
            ModuleTypes::Socket3->value => new Socket3Controller($service),
            ModuleTypes::Socket4->value => new Socket4Controller($service),
            ModuleTypes::Socket5->value => new Socket5Controller($service),
            ModuleTypes::SocketGiant->value => new SocketGiantController($service),
            default => new FallbackModuleController($service),
        };
    }
}
