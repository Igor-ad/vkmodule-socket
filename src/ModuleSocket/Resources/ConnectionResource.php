<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;

class ConnectionResource extends BaseResource
{
    public function dataToArray(Response $response): array
    {
        return [
            'data' => [
                'status' => 'online',
            ],
        ];
    }
}
