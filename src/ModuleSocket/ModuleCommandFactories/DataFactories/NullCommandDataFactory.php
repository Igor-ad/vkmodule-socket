<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;

class NullCommandDataFactory implements CommandDataFactory
{
    public function make(): ?CommandData
    {
        return null;
    }
}
