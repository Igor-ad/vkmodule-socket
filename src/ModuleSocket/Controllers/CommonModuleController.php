<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Controllers;

use Autodoctor\ModuleSocket\ModuleCommandFactories\ModuleCommandFormatters\CommonFormatter;
use Autodoctor\ModuleSocket\Resources\ConnectionResource;
use Autodoctor\ModuleSocket\Resources\FirmwareResource;
use Autodoctor\ModuleSocket\Resources\RebootResource;
use Autodoctor\ModuleSocket\Resources\UidResource;
use Autodoctor\ModuleSocket\Services\Service;

class CommonModuleController implements CommonModuleControllerInterface
{
    public function __construct(
        protected Service $service,
    ) {
    }

    public function checkConnection(): string
    {
        $command = CommonFormatter::checkConnect();
        $response = $this->service->getResponse($command);

        return ConnectionResource::make($this->service->getValidator())->toJson($response);
    }

    public function getModuleUID(): string
    {
        $command = CommonFormatter::getModuleUid();
        $response = $this->service->getResponse($command);

        return UidResource::make($this->service->getValidator())->toJson($response);
    }

    public function rebootModule(): string
    {
        $command = CommonFormatter::rebootModule();
        $response = $this->service->getResponse($command);

        return RebootResource::make($this->service->getValidator())->toJson($response);
    }

    public function getModuleFirmware(): string
    {
        $command = CommonFormatter::getFirmware();
        $response = $this->service->getResponse($command);

        return FirmwareResource::make($this->service->getValidator())->toJson($response);
    }
}
