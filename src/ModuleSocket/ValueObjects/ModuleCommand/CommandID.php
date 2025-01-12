<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand;

final readonly class CommandID
{
    public function __construct(
        public string $id,
    ) {
    }

    public function toStream(): string
    {
        return chr(hexdec($this->id));
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function isEqual(CommandID $anotherCommandID): bool
    {
        return $this->id === $anotherCommandID->id;
    }
}
