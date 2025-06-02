<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Files: string
{
    case ApiLogFile = '/log/api_module.log';
    case CliLogFile = '/log/cli_module.log';
    case ConfigFile = '/config/vk_module.php';
    case CliFile = '/console/cli.php';
    case TcpServer = '/console/server.php';

    case TestApiLogFile = '/tests/log/api_module.log';
    case TestCliLogFile = '/tests/log/cli_module.log';
    case TestConfigFile = '/tests/config/test_config.php';
    case TestTcpServer = '/console/test_server.php';

    public function getPath(): string
    {
        $basePath = dirname(__DIR__, 3);

        return $basePath . DIRECTORY_SEPARATOR . ltrim($this->value, '/');
    }
}
