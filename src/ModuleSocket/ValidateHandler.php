<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket;

use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Enums\Socket1;
use Autodoctor\ModuleSocket\Enums\Socket2;
use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\Enums\Socket4;
use Autodoctor\ModuleSocket\Enums\Socket5;
use Autodoctor\ModuleSocket\Enums\SocketGiant;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;

trait ValidateHandler
{
    /**
     * @throws ConfiguratorException
     */
    private function getCommandIdRule(string $moduleType = null): array
    {
        $moduleType = $moduleType ?? Configurator::instance(Files::ConfigFile->getPath())->get('type');

        return match ($moduleType) {
            Socket1::TYPE => Socket1::getModuleCommands(),
            Socket2::TYPE => Socket2::getModuleCommands(),
            Socket3::TYPE => Socket3::getModuleCommands(),
            Socket4::TYPE => Socket4::getModuleCommands(),
            Socket5::TYPE => Socket5::getModuleCommands(),
            SocketGiant::TYPE => SocketGiant::getModuleCommands(),
            default => [],
        };
    }

    /**
     * @throws ConfiguratorException
     */
    private function resolveInput(int $inputNumber, string $moduleType = null): bool
    {
        $moduleType = $moduleType ?? Configurator::instance(Files::ConfigFile->getPath())->get('type');

        return match ($moduleType) {
            Socket1::TYPE => Socket1::resolveInput($inputNumber),
            Socket2::TYPE => Socket2::resolveInput($inputNumber),
            Socket5::TYPE => Socket5::resolveInput($inputNumber),
            SocketGiant::TYPE => SocketGiant::resolveInput($inputNumber),
            default => false,
        };
    }

    /**
     * @throws ConfiguratorException
     */
    private function resolveRelay(int $relayNumber, string $moduleType = null): bool
    {
        $moduleType = $moduleType ?? Configurator::instance(Files::ConfigFile->getPath())->get('type');

        return match ($moduleType) {
            Socket2::TYPE => Socket2::resolveRelay($relayNumber),
            Socket3::TYPE => Socket3::resolveRelay($relayNumber),
            Socket4::TYPE => Socket4::resolveRelay($relayNumber),
            Socket5::TYPE => Socket5::resolveRelay($relayNumber),
            SocketGiant::TYPE => SocketGiant::resolveRelay($relayNumber),
            default => false,
        };
    }
}
