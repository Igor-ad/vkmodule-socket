<?php

declare(strict_types=1);

namespace Tests;

use Autodoctor\ModuleSocket\Configurator;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;

class LocalSocketServerInit extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $port = Configurator::instance(Files::TestConfigFile->getPath())->get('port');
        $timeout = Configurator::instance(Files::TestConfigFile->getPath())->get('timeout');

        $resource = @fsockopen('localhost', $port);

        if ($resource === false) {
            $server = Files::TcpServer->getPath() . " '$port' '$timeout' >/dev/null 2>&1 &";
            exec($server);
            usleep(400 * 1000);
        }
    }
}
