<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validator;

final readonly class RelayGroup implements CommandData
{
    public string $data;
    public array $relayGroup;

    /**
     * @throws InvalidInputParameterException
     */
    public function __construct(string $data)
    {
        $this->data = Validator::instance()->validateRelayGroupControlData($data);
        $this->relayGroup = $this->iterate($this->data);
    }

    /**
     * @throws InvalidInputParameterException
     */
    private function makeRelayObject($relayNumber, $action): Relay
    {
        return new Relay(relayNumber: $relayNumber, action: $action, interval: 0);
    }

    private function iterate(string $data): array
    {
        $sequence = range(15, 0);

        return array_map(
        /**
         * @throws InvalidInputParameterException
         */
            fn($key): Relay => $this->makeRelayObject($key, bitMask($data, $key)),
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
            'relayGroup' => [
                'relayGroupAction' => $this->data,
            ]
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
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
