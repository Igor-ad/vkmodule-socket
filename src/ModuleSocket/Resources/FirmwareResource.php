<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;

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
                'controllerType' => $this->getControllerType($response->getItem(0)),
                'version' => implode(array_slice($response->data, 1, 2)),
                'firmwareType' => $this->getFirmwareType($response->getItem(3)),
                'firmware' => implode($response->data),
            ],
        ];
    }

    private function getControllerType(string $controllerTypeId): string
    {
        return match ((int)$controllerTypeId) {
            1 => 'VRD-E',
            2 => 'Socket-2',
            3 => 'Socket-1',
            4 => 'Socket-3',
            5 => 'Socket-4',
            6 => 'Socket-5',
            7 => 'Socket-Giant',
            default => 'UnknownModuleType'
        };
    }

    private function getFirmwareType(string $type): string
    {
        return (int)$type === 0 ? 'regular' : 'exclusive';
    }
}
