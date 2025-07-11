<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\DTO;

use Autodoctor\ModuleSocket\Enums\Commands;

class Response
{
    public readonly string $id;
    public readonly ?array $data;
    public bool $success;

    public function __construct(
        public string $responseData,
    ) {
        $data = str_split($responseData, 2);

        $this->id = array_shift($data);
        $this->data = count($data) ? $data : null;
        $this->success = true;
    }

    public static function getDto(string $responseData): Response
    {
        return new Response($responseData);
    }

    public function dataToHexString(): string
    {
        return implode('', $this->data ?: []);
    }

    public function getItem(int $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'event' => [
                'id' => $this->id,
                'description' => Commands::description($this->id),
                'data' => $this->data ?: null,
            ],
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
