<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Configuration;

use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use Autodoctor\ModuleSocket\Enums\Socket1;
use Autodoctor\ModuleSocket\Enums\Socket2;
use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\Enums\Socket4;
use Autodoctor\ModuleSocket\Enums\Socket5;
use Autodoctor\ModuleSocket\Enums\SocketGiant;

/**
 * Per hardware type: which input / relay indices exist on the device (numeric rules still live on socket enums).
 */
final class ModuleHardwareCapabilities
{
    public static function isInputNumberAllowedForModuleType(int $inputNumber, string $moduleType): bool
    {
        return match ($moduleType) {
            ModuleTypes::Socket1->value => Socket1::resolveInput($inputNumber),
            ModuleTypes::Socket2->value => Socket2::resolveInput($inputNumber),
            ModuleTypes::Socket5->value => Socket5::resolveInput($inputNumber),
            ModuleTypes::SocketGiant->value => SocketGiant::resolveInput($inputNumber),
            default => false,
        };
    }

    public static function isRelayNumberAllowedForModuleType(int $relayNumber, string $moduleType): bool
    {
        return match ($moduleType) {
            ModuleTypes::Socket2->value => Socket2::resolveRelay($relayNumber),
            ModuleTypes::Socket3->value => Socket3::resolveRelay($relayNumber),
            ModuleTypes::Socket4->value => Socket4::resolveRelay($relayNumber),
            ModuleTypes::Socket5->value => Socket5::resolveRelay($relayNumber),
            ModuleTypes::SocketGiant->value => SocketGiant::resolveRelay($relayNumber),
            default => false,
        };
    }

    /**
     * DS18B20 wire value limits for Socket-3 (see {@see Socket3} constants).
     */
    public static function isSocket3TemperatureOutOfRange(int $data, int $sign): bool
    {
        return $data > Socket3::MAX_TEMPERATURE
            || (($data > Socket3::NEG_MIN_TEMPERATURE) && $sign !== 0);
    }
}
