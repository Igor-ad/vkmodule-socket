<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Configuration;

interface ConfigurationProviderInterface
{
    public function get(string $key, mixed $default = null): mixed;
}
