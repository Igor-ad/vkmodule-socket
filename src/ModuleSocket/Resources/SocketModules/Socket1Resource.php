<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

/**
 * data:
 *       0 Byte Input number (0...3)
 *       1 Byte 1 – Processing on; 0 – Processing off (default on)
 *       2 Byte Anti-bounce duration *20ms. (default 5 <=> 100ms)
 */
class Socket1Resource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'inputNumber' => hexdec($response->getItem(0)),
                    'triggerAction' => $this->inputStatusToSting($response->getItem(1)),
                    'antiBounce' => hexdec($response->getItem(2)),
                ],
            ]
        ];
    }
}
