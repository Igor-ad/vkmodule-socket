<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket2Formatter;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2AllInputAndRelayStatusResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2RelayActionResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2Resource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket2wAnalogInputStatusResource;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

class Socket2Controller extends Controller
{
    public function getAllStatus(): string
    {
        $command = Socket2Formatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return Socket2AllInputAndRelayStatusResource::make()->toJson($response);
    }

    public function getAnalogInput(): string
    {
        $command = Socket2Formatter::getAnalogInput();
        $response = $this->service->getResponse($command);

        return Socket2wAnalogInputStatusResource::make()->toJson($response);
    }

    public function getInput(InputStatus|CommandData $commandData): string
    {
        $command = Socket2Formatter::getInputStatus($commandData);
        $response = $this->service->getResponse($command);

        return Socket2Resource::make()->toJson($response);
    }

    public function relayAction(Relay|CommandData $commandData): string
    {
        $command = Socket2Formatter::relayAction($commandData);
        $response = $this->service->getResponse($command);

        return Socket2RelayActionResource::make()->toJson($response);
    }

    public function inputSetup(Input|CommandData $commandData): string
    {
        $command = Socket2Formatter::inputSetup($commandData);
        $response = $this->service->getResponse($command);

        return Socket2Resource::make()->toJson($response);
    }
}
