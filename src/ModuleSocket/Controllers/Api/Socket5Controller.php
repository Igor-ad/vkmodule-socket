<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket5Formatter;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket5AllInputAndRelayStatusResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket5RelayActionResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket5Resource;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

class Socket5Controller extends Controller
{
    public function getAllStatus(): string
    {
        $command = Socket5Formatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return Socket5AllInputAndRelayStatusResource::make()->toJson($response);
    }

    public function getInput(InputStatus|CommandData $commandData): string
    {
        $command = Socket5Formatter::getInputStatus($commandData);
        $response = $this->service->getResponse($command);

        return Socket5Resource::make()->toJson($response);
    }

    public function inputSetup(Input|CommandData $commandData): string
    {
        $command = Socket5Formatter::inputSetup($commandData);
        $response = $this->service->getResponse($command);

        return Socket5Resource::make()->toJson($response);
    }

    public function relayAction(Relay|CommandData $commandData): string
    {
        $command = Socket5Formatter::relayAction($commandData);
        $response = $this->service->getResponse($command);

        return Socket5RelayActionResource::make()->toJson($response);
    }
}
