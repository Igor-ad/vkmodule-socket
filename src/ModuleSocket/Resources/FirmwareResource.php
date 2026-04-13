<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;

/**
 * data:
 *       0  Byte controller type (
 *            VRD-E = 1,
 *            Socket-2 = 2,
 *            Socket-1 = 3,
 *            Socket-3 = 4,
 *            Socket-4 = 5,
 *            Socket-5 = 6,
 *            Socket-Giant = 7
 *        );
 *       1 Byte version number (Hi);
 *       2 Byte version number (Lo);
 *       3 Byte firmware type (regular - 0, exclusive - code different from 0);
 */
class FirmwareResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'controllerType' => $this->getControllerType($response->getEventDataItem(0)),
                'version' => implode('', array_slice($response->getEventData() ?? [], 1, 2)),
                'firmwareType' => $this->getFirmwareType($response->getEventDataItem(3)),
                'firmware' => implode('', $response->getEventData() ?? []),
            ],
        ];
    }

    public function getControllerType(?string $controllerTypeId): string
    {
        return match ((int) $controllerTypeId) {
            1 => 'VRD-E',
            2 => ModuleTypes::Socket2->value,
            3 => ModuleTypes::Socket1->value,
            4 => ModuleTypes::Socket3->value,
            5 => ModuleTypes::Socket4->value,
            6 => ModuleTypes::Socket5->value,
            7 => ModuleTypes::SocketGiant->value,
            default => 'UnknownModuleType',
        };
    }

    private function getFirmwareType(?string $type): string
    {
        return (int)$type === 0 ? 'regular' : 'exclusive';
    }
}
