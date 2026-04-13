<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;

/**
 * `relayGroupAction` must satisfy {@see \Autodoctor\ModuleSocket\Validation\ValidatorInterface::validateRelayGroupControlData()}
 * before {@see self::fromArray()}.
 */
final readonly class RelayGroup implements CommandData
{
    public string $data;

    public array $relayGroup;

    private function __construct(string $data)
    {
        $this->data = $data;
        $this->relayGroup = $this->iterate($this->data);
    }

    public static function fromArray(array $relayGroup): self
    {
        return new self(data: $relayGroup['relayGroupAction']);
    }

    private function iterate(string $data): array
    {
        $sequence = range(15, 0);

        return array_map(
            fn (int $key): Relay => Relay::fromArray([
                'relayNumber' => $key,
                'action' => bitMask($data, $key),
                'interval' => 0,
            ]),
            $sequence
        );
    }

    public function isEqual(CommandData $anotherCommandData): bool
    {
        return $this->toString() === $anotherCommandData->toString();
    }

    public function toArray(): array
    {
        return [
            CommandDataRootKey::RelayGroup->value => [
                'relayGroupAction' => $this->data,
            ],
        ];
    }

    public function toStream(): string
    {
        return chr(hexdec($this->data));
    }

    public function toString(): string
    {
        return hexFormat(hexdec($this->data), 4);
    }
}
