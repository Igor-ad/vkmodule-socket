<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket;

use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;

class Configurator
{
    public const CONFIG_FILE = __DIR__ . '/../../config/vk_module.php';

    private static ?Configurator $instance = null;
    private array $config = [];

    /**
     * @throws ConfiguratorException
     */
    private function __construct(string $configFile)
    {
        $this->setConfig($configFile);
    }

    /**
     * @throws ConfiguratorException
     */
    public static function instance(string $configFile = self::CONFIG_FILE): self
    {
        self::$instance = self::$instance ?? new self($configFile);

        return self::$instance;
    }

    /**
     * @throws ConfiguratorException
     */
    private function setConfig(string $configFile): void
    {
        $config = include_once($configFile);

        if (!is_array($config)) {
            throw new ConfiguratorException('Error reading configuration.');
        }

        $this->config = $config;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }
}
