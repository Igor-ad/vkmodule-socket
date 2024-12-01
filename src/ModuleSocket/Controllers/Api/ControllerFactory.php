<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Enums\Socket1;
use Autodoctor\ModuleSocket\Enums\Socket2;
use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\Enums\Socket4;
use Autodoctor\ModuleSocket\Enums\Socket5;
use Autodoctor\ModuleSocket\Enums\SocketGiant;
use Autodoctor\ModuleSocket\Services\Service;

class ControllerFactory
{
    public static function make(Service $service, string $moduleType): ControllerInterface
    {
        return match ($moduleType) {
            Socket1::TYPE => new Socket1Controller($service),
            Socket2::TYPE => new Socket2Controller($service),
            Socket3::TYPE => new Socket3Controller($service),
            Socket4::TYPE => new Socket4Controller($service),
            Socket5::TYPE => new Socket5Controller($service),
            SocketGiant::TYPE => new SocketGiantController($service),
            default => new Controller($service),
        };
    }
}
