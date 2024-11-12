<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;

/**
 * Example of a CLI query string for a single-module system:
 *      '{"command":{"data":{"relay":{"relayNumber":0}}}}'
 *  Or for a multi-module system:
 *      '{"module":{"ip":"192.168.4.191","port":9761,"type":"Socket-2"},"command":{"data":{"relay":{"relayNumber":0}}}}'
 */
class ApiRelayOff extends AbstractApiCommand
{
    public string $name = 'api_relay_off';
    protected string $controllerMethod = 'relayAction';

    /**
     * @throws InvalidInputParameterException
     */
    protected function run(ControllerInterface $controller): string
    {
        $relayNumber = $this->getValidRelayNumber();

        return $controller->relayAction(new Relay(relayNumber: $relayNumber, action: 0));
    }
}
