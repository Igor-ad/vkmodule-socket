<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\Validation\ValidatorInterface;

class AbstractResource implements Resource
{
    public function __construct(
        protected ?ValidatorInterface $validator = null,
    ) {
    }

    public static function make(?ValidatorInterface $validator = null): static
    {
        return new static($validator);
    }

    /**
     * Validator from the service/controller when available; otherwise a one-off default for standalone use/tests.
     * Prefer passing {@see ValidatorInterface} from {@see \Autodoctor\ModuleSocket\Services\Service::getValidator()}.
     */
    protected function validation(): ValidatorInterface
    {
        return $this->validator ??= new Validator(
            ConfigurationProvider::fromConfigFile(Files::ConfigFile->getPath())
        );
    }

    public function toArray(Response $response): array
    {
        return $response->toArray();
    }

    public function toJson(Response $response): string
    {
        return json_encode($this->toArray($response));
    }
}
