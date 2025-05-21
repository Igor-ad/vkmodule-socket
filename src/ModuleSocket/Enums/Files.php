<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

enum Files: string
{
    case ApiLogFile = '/log/api_module.log';
    case CliLogFile = '/log/cli_module.log';
    case ConfigFile = '/config/vk_module.php';
    case TcpServer = '/console/server.php';

    public function getPath(): string
    {
        $basePath = dirname(__DIR__, 3);

        return $basePath . DIRECTORY_SEPARATOR . ltrim($this->value, '/');
    }
}
