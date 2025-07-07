<?php

declare(strict_types=1);

namespace Tests\Feature;

use Autodoctor\ModuleSocket\Configurator;
use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\TestCase;

class ProxyLocalSocketServerInit extends TestCase
{
    public function proxyServerInit(string $outgoingStream): void
    {
        $port = Configurator::instance(Files::TestConfigFile->getPath())->get('port');
        $timeout = Configurator::instance(Files::TestConfigFile->getPath())->get('timeout');
        // base64_encode() - the hack to overcome passing null bytes as an argument
        $encodeOutgoingStream = base64_encode($outgoingStream);

        $resource = @fsockopen('localhost', $port);

        if ($resource === false) {
            $serverCmd = Files::TestTcpServer->getPath() . " '$port' '$timeout' '$encodeOutgoingStream' >/dev/null 2>&1 &";
            exec($serverCmd);
            usleep(150 * 1000);
        }
    }
}
