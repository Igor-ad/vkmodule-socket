<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleEvent;

use Autodoctor\ModuleSocket\Enums\Events;

final readonly class Event
{
    public function __construct(
        public string $eventID,
        public ?array $data,
    ) {
    }

    public function toArray(): array
    {
        return [
            'event' => [
                'id' => $this->eventID,
                'description' => Events::description($this->eventID),
                'data' => $this->data,
            ],
        ];
    }

    public function isEqual(Event $anotherEvent): bool
    {
        return $this->toArray() === $anotherEvent->toArray();
    }
}
