<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Configuration;

use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use JsonException;

/**
 * Loads key/value configuration used by {@see \Autodoctor\ModuleSocket\Validation\Validator} and defaults (e.g. module host).
 *
 * PHP project configs typically `return [ ... ];` — that is executable PHP, so {@see fromConfigFile()} uses `include`
 * (same as a manual `require` in bootstrap). There is no safe way to read arbitrary PHP array files without executing them.
 * For non-executable config, use {@see fromJsonFile()} with `file_get_contents` + `json_decode`.
 */
final readonly class ConfigurationProvider implements ConfigurationProviderInterface
{
    public function __construct(private array $config)
    {
    }

    /**
     * PHP `return [ ... ]` configs are executed via `include` (same pattern as `config/vk_module.php`).
     *
     * @throws ConfiguratorException
     */
    public static function fromConfigFile(string $configFile): self
    {
        if (!is_file($configFile)) {
            throw new ConfiguratorException(sprintf('Configuration file "%s" not found.', $configFile));
        }

        $config = include $configFile;

        if (!is_array($config)) {
            throw new ConfiguratorException('Error reading configuration.');
        }

        return new self($config);
    }

    /**
     * @throws ConfiguratorException
     */
    public static function fromJsonFile(string $configFile): self
    {
        if (!is_file($configFile)) {
            throw new ConfiguratorException(sprintf('Configuration file "%s" not found.', $configFile));
        }

        $raw = file_get_contents($configFile);
        if ($raw === false) {
            throw new ConfiguratorException(sprintf('Could not read configuration file "%s".', $configFile));
        }

        try {
            $config = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new ConfiguratorException(
                'Invalid JSON configuration: ' . $exception->getMessage(),
                0,
                $exception
            );
        }

        if (!is_array($config)) {
            throw new ConfiguratorException('JSON configuration must decode to an array.');
        }

        return new self($config);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }
}
