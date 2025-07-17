<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\ValueObjects\ModuleEvent\Event;

class Response
{
    public readonly Event $event;
    public bool $success;

    public function __construct(
        public readonly string $responseData,
    ) {
        $data = str_split($responseData, 2);
        $eventId = array_shift($data);
        $eventData = count($data) ? $data : null;
        $this->event = new Event($eventId, $eventData);
        $this->success = true;
    }

    public static function getDto(string $responseData): self
    {
        return new self($responseData);
    }

    public function dataToHexString(): string
    {
        return implode('', $this->event->data ?: []);
    }

    public function getEventData(): ?array
    {
        return $this->event->data;
    }

    public function getEventId(): string
    {
        return $this->event->eventID;
    }

    public function getEventDataItem(int $key): mixed
    {
        return $this->event->data[$key] ?? null;
    }

    public function toArray(): array
    {
        return array_merge(['success' => $this->success], $this->event->toArray());
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
