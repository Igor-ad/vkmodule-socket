<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;

class Socket2AllInputAndRelayStatusResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'input' => [
                    'input0' => $this->inputStatusToSting($response->getItem(0)),
                    'input1' => $this->inputStatusToSting($response->getItem(1)),
                ],
                'relay' => [
                    'relay0' => $this->relayStatusToSting($response->getItem(2)),
                    'relay1' => $this->relayStatusToSting($response->getItem(3)),
                ]
            ]
        ];
    }
}
