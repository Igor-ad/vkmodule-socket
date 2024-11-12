<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
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

class SocketGiantController extends Controller
{
    public function getAllStatus(): string
    {
        $command = SocketGiantFormatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return SocketGiantAllInputAndRelayStatusResource::make()->toJson($response);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function getInput(InputStatus|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::getInputStatus($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantResource::make()->toJson($response);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function relayGroupAction(RelayGroup|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::relayGroupAction($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantGroupRelayActionResource::make()->toJson($response);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function relayAction(Relay|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::relayAction($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantRelayActionResource::make()->toJson($response);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function inputSetup(Input|CommandData $commandData): string
    {
        $command = SocketGiantFormatter::setupInput($commandData);
        $response = $this->service->getResponse($command);

        return SocketGiantResource::make()->toJson($response);
    }
}
