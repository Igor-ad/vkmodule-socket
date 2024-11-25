<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;

class AbstractResource implements Resource
{
    public static function make(): static
    {
        return new static();
    }

    /**
     * @throws ModuleException
     */
    public function toArray(Response $response): array
    {
        return $response->toArray();
    }

    /**
     * @throws ModuleException
     */
    public function toJson(Response $response): string
    {
        return json_encode($this->toArray($response));
    }
}
