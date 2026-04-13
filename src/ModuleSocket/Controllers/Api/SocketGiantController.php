<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\AbstractModuleController;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\SocketGiantFormatter;
use Autodoctor\ModuleSocket\Resources\SocketModules\SocketGiantAllInputAndRelayStatusResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\SocketGiantGroupRelayActionResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\SocketGiantRelayActionResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\SocketGiantResource;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;

class SocketGiantController extends AbstractModuleController
{
    public function getAllStatus(): string
    {
        $command = SocketGiantFormatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return SocketGiantAllInputAndRelayStatusResource::make($this->service->getValidator())->toJson($response);
    }

    public function getInput(InputStatus|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::getInputStatus($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantResource::make($this->service->getValidator())->toJson($response);
    }

    public function relayGroupAction(RelayGroup|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::relayGroupAction($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantGroupRelayActionResource::make($this->service->getValidator())->toJson($response);
    }

    public function relayAction(Relay|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::relayAction($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantRelayActionResource::make($this->service->getValidator())->toJson($response);
    }

    public function inputSetup(Input|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::setupInput($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantResource::make($this->service->getValidator())->toJson($response);
    }
}
