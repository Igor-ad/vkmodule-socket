<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProviderInterface;
use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\Validation\ValidatorInterface;

final readonly class Module
{
    public const DEFAULT_PORT = 9761;

    public string $host;
    public int $port;
    public string $type;

    /**
     * @throws InvalidInputParameterException
     */
    public function __construct(
        ?string $host = null,
        ?int $port = null,
        ?string $type = null,
        ?ConfigurationProviderInterface $configuration = null,
        ?ValidatorInterface $validator = null,
    ) {
        $resolvedConfiguration = $configuration ?? ConfigurationProvider::fromConfigFile(Files::ConfigFile->getPath());
        $resolvedValidator = $validator ?? new Validator($resolvedConfiguration);

        $this->host = $resolvedValidator->validateHost(
            $host ?? (string) $resolvedConfiguration->get('host')
        );
        $this->port = $resolvedValidator->validatePort(
            $port ?? (int) ($resolvedConfiguration->get('port') ?? self::DEFAULT_PORT)
        );
        $this->type = $resolvedValidator->validateType(
            $type ?? (string) $resolvedConfiguration->get('type')
        );
    }

    public function isEqual(Module $anotherModule): bool
    {
        return $this->toArray() === $anotherModule->toArray();
    }

    public function toArray(): array
    {
        return [
            'module' => [
                'host' => $this->host,
                'port' => $this->port,
                'type' => $this->type,
            ]
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
