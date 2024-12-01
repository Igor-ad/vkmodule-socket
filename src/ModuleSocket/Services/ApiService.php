<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

class ApiService extends AbstractService
{
    public function getResponse(Command $command): Response
    {
        $closure = $this->call($command);

        return $closure();
    }
}
