<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

interface Service
{
    public function getResponse(Command $command): Response;
}
