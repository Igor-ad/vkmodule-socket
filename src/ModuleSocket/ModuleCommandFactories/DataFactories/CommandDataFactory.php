<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;

interface CommandDataFactory
{
    public function make(): ?CommandData;
}
