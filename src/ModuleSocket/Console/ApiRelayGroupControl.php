<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

/**
 * Example of a CLI query string for a single-module system:
 *  '{"command":{"data":{"relay":{"relayGroupAction":"ffff"}}}}'
 *      (Turn all relays to the "On" position)
 *  Or for a multi-module system:
 *  '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-Giant"},"command":{"data":{"relay":{"relayGroupAction":"0000"}}}}'
 *      (Turn all relays to the "Off" position)
 */
class ApiRelayGroupControl extends AbstractApiCommand
{
    public string $name = 'api_relay_group_control';
    protected ?string $controllerMethod = 'relayGroupAction';
}
