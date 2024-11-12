<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket4Formatter;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket4AllRelayStatusResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket4RelayActionResource;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

class Socket4Controller extends Controller
{
    public function getAllStatus(): string
    {
        $command = Socket4Formatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return Socket4AllRelayStatusResource::make()->toJson($response);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function relayAction(Relay|CommandData $commandData): string
    {
        $command = Socket4Formatter::relayAction($commandData);
        $response = $this->service->getResponse($command);

        return Socket4RelayActionResource::make()->toJson($response);
    }
}
