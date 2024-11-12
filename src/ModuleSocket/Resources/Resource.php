<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\DTO\Response;

interface Resource
{
    public function toArray(Response $response): array;

    public function toJson(Response $response): string;
}
