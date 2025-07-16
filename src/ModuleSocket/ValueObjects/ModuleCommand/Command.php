<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand;

use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\CommandData;

final readonly class Command
{
    public function __construct(
        public CommandID $commandID,
        public ?CommandData $commandData = null,
    ) {
    }

    public function toStream(): string
    {
        return $this->commandID->toStream() . $this->commandData?->toStream();
    }

    public function toString(): string
    {
        return $this->commandID->toString() . $this->commandData?->toString();
    }

    public function toArray(): array
    {
        return [
            'command' => [
                'id' => $this->commandID->id,
                'description' => toPascalCase(Commands::description($this->commandID->id)),
                'data' => $this->commandData?->toArray(),
            ],
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function isEqual(Command $anotherCommand): bool
    {
        return $this->toArray() === $anotherCommand->toArray();
    }
}
