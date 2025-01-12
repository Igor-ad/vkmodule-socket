<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers\Api;

use Autodoctor\ModuleSocket\Controllers\AbstractController;
use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\CommonFormatter;
use Autodoctor\ModuleSocket\Resources\ConnectionResource;
use Autodoctor\ModuleSocket\Resources\FirmwareResource;
use Autodoctor\ModuleSocket\Resources\RebootResource;
use Autodoctor\ModuleSocket\Resources\UidResource;

class Controller extends AbstractController
{
    public function checkConnection(): string
    {
        $command = CommonFormatter::checkConnect();
        $response = $this->service->getResponse($command);

        return ConnectionResource::make()->toJson($response);
    }

    public function getModuleUID(): string
    {
        $command = CommonFormatter::getModuleUid();
        $response = $this->service->getResponse($command);

        return UidResource::make()->toJson($response);
    }

    public function rebootModule(): string
    {
        $command = CommonFormatter::rebootModule();
        $response = $this->service->getResponse($command);

        return RebootResource::make()->toJson($response);
    }

    public function getModuleFirmware(): string
    {
        $command = CommonFormatter::getFirmware();
        $response = $this->service->getResponse($command);

        return FirmwareResource::make()->toJson($response);
    }
}
