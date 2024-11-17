<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket;

use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;

class Configurator
{
    const CONFIG_FILE = __DIR__ . '/../../config/vk_module.php';

    private static ?Configurator $instance = null;
    private array $values = [];

    /**
     * @throws ConfiguratorException
     */
    private function __construct()
    {
        $this->config();
    }

    public static function instance(): self
    {
        self::$instance = self::$instance ?? new self();

        return self::$instance;
    }

    /**
     * @throws ConfiguratorException
     */
    private function config(): void
    {
        $config = include_once(self::CONFIG_FILE);

        if (!is_array($config)) {
            throw new ConfiguratorException('Error reading configuration.');
        }

        $this->values = $config;
    }

    public function get(string $key): mixed
    {
        return $this->values[$key] ?? null;
    }
}
