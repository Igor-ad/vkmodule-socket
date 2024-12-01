<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket;

use Autodoctor\ModuleSocket\Enums\Common;
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
        $moduleType = $moduleType ?? Configurator::instance()->get('type');

        return match ($moduleType) {
            Socket1::TYPE => $this->mergeWithCommonCmd(Socket1::COMMANDS),
            Socket2::TYPE => $this->mergeWithCommonCmd(Socket2::COMMANDS),
            Socket3::TYPE => $this->mergeWithCommonCmd(Socket3::COMMANDS),
            Socket4::TYPE => $this->mergeWithCommonCmd(Socket4::COMMANDS),
            Socket5::TYPE => $this->mergeWithCommonCmd(Socket5::COMMANDS),
            SocketGiant::TYPE => $this->mergeWithCommonCmd(SocketGiant::COMMANDS),
            default => [],
        };
    }

    /**
     * @throws ConfiguratorException
     */
    private function getInputRule(string $moduleType = null): array
    {
        $moduleType = $moduleType ?? Configurator::instance()->get('type');

        return match ($moduleType) {
            Socket1::TYPE => Socket1::allowedInput(),
            Socket2::TYPE => Socket2::allowedInput(),
            Socket5::TYPE => Socket5::allowedInput(),
            SocketGiant::TYPE => SocketGiant::allowedInput(),
            default => [],
        };
    }

    /**
     * @throws ConfiguratorException
     */
    private function getRelayRule(string $moduleType = null): array
    {
        $moduleType = $moduleType ?? Configurator::instance()->get('type');

        return match ($moduleType) {
            Socket2::TYPE => Socket2::allowedRelay(),
            Socket3::TYPE => Socket3::allowedRelay(),
            Socket4::TYPE => Socket4::allowedRelay(),
            Socket5::TYPE => Socket5::allowedRelay(),
            SocketGiant::TYPE => SocketGiant::allowedRelay(),
            default => [],
        };
    }

    private function mergeWithCommonCmd(array $moduleCommands): array
    {
        return array_merge(Common::COMMANDS, $moduleCommands);
    }
}
