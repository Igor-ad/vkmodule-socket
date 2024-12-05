<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\Socket3Formatter;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket3AllSensorAndRelayStatusResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket3RelayActionResource;
use Autodoctor\ModuleSocket\Resources\SocketModules\Socket3TemperatureSensorResource;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

class Socket3Controller extends Controller
{
    public function getAllStatus(): string
    {
        $command = Socket3Formatter::getAllStatus();
        $response = $this->service->getResponse($command);

        return Socket3AllSensorAndRelayStatusResource::make()->toJson($response);
    }

    public function getSensor0(): string
    {
        $command = Socket3Formatter::getSensor0();
        $response = $this->service->getResponse($command);

        return Socket3TemperatureSensorResource::make()->toJson($response);
    }

    public function getSensor1(): string
    {
        $command = Socket3Formatter::getSensor1();
        $response = $this->service->getResponse($command);

        return Socket3TemperatureSensorResource::make()->toJson($response);
    }

    public function relayAction(Relay|CommandData $commandData): string
    {
        $command = Socket3Formatter::relayAction($commandData);
        $response = $this->service->getResponse($command);

        return Socket3RelayActionResource::make()->toJson($response);
    }
}
