<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

interface CommandData
{
    public function isEqual(CommandData $anotherCommandData): bool;

    public function toArray(): array;

    public function toJson(): string;

    public function toStream(): string;

    public function toString(): string;
}
