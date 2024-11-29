<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\ValueObjects;

use Autodoctor\ModuleSocket\Configurator;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validator;

final readonly class Module
{
    public const DEFAULT_PORT = 9761;

    public string $host;
    public int $port;
    public string $type;

    /**
     * @throws InvalidInputParameterException
     */
    public function __construct(?string $host = null, ?int $port = null, ?string $type = null)
    {
        $this->host = Validator::instance()->validateHost($this->setHost($host));
        $this->port = Validator::instance()->validatePort($this->setPort($port));
        $this->type = Validator::instance()->validateType($this->setType($type));
    }

    private function setHost(?string $host): string
    {
        return $host ?? Configurator::instance()->get('host');
    }

    private function setPort(?int $port): int
    {
        return $port ?? Configurator::instance()->get('port') ?? self::DEFAULT_PORT;
    }

    private function setType(?string $type): string
    {
        return $type ?? Configurator::instance()->get('type');
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
