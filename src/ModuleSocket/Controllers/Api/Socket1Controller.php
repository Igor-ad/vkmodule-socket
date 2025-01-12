<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket1Formatter;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket1AllInputStatusResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket1Resource;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;

class Socket1Controller extends Controller
{
    public function getAllStatus(): string
    {
        $command = Socket1Formatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return Socket1AllInputStatusResource::make()->toJson($response);
    }

    public function getInput(InputStatus|CommandData $commandData): string
    {
        $command = Socket1Formatter::getInputStatus($commandData);
        $response = $this->service->getResponse($command);

        return Socket1Resource::make()->toJson($response);
    }

    public function inputSetup(Input|CommandData $commandData): string
    {
        $command = Socket1Formatter::inputSetup($commandData);
        $response = $this->service->getResponse($command);

        return Socket1Resource::make()->toJson($response);
    }
}
