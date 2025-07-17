<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;

class BaseResource extends AbstractResource
{
    public function toArray(Response $response): array
    {
        $responseToArray = parent::toArray($response);
        $responseToArray['event']['data'] = $this->dataToArray($response)['data'];

        return $responseToArray;
    }

    public function dataToArray(Response $response): array
    {
        return ['data' => $response->getEventData()];
    }

    public function inputStatusToSting(int|string $status): string
    {
        return (int)$status ? 'Open' : 'Closed';
    }

    public function relayStatusToSting(int|string $status): string
    {
        return (int)$status ? 'On' : 'Off';
    }
}
