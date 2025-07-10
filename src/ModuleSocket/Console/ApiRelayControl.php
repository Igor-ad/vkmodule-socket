<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

/**
 * Example of a CLI query string for a single-module system:
 *      '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":30}}}}'
 * Or for a multi-module system:
 *      '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"},"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":30}}}}'
 */
class ApiRelayControl extends AbstractApiCommand
{
    public string $name = 'api_relay_control';
    protected ?string $controllerMethod = 'relayAction';
}
