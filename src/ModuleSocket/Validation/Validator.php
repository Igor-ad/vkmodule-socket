<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Validation;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProviderInterface;
use Autodoctor\ModuleSocket\Configuration\ModuleCommandRegistry;
use Autodoctor\ModuleSocket\Configuration\ModuleHardwareCapabilities;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Enums\ModuleTypes;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

class Validator implements ValidatorInterface
{
    public function __construct(
        private readonly ConfigurationProviderInterface $configuration,
    ) {
    }

    /** @throws InvalidRequestCommandException */
    public function validateModuleCommandId(string $commandId, ?string $moduleType = null): bool
    {
        $moduleType = $moduleType ?? (string) $this->configuration->get('type');

        if (!ModuleCommandRegistry::isWireCommandAllowedForModuleType($commandId, $moduleType)) {
            throw new InvalidRequestCommandException(
                sprintf('This command ID "%s" is not supported by controllers', $commandId)
            );
        }

        return true;
    }

    /** @throws UnknownCommandException */
    public function validateEventId(string $commandId, string $responseId): bool
    {
        return match (true) {
            ModuleCommandRegistry::isWireSetInputCommandId($responseId) => true,
            $responseId === $commandId => true,
            $responseId === Common::UNKNOWN => throw new UnknownCommandException(
                'An unknown (not supported by this controller) command was received'
                . ' or the command parameters are not set correctly'
            ),
            default => false,
        };
    }

    /** @throws InvalidInputParameterException */
    public function validateRelayAction(int $action): int
    {
        $validate = in_array($action, Common::POSSIBLE_RELAY_ACTIONS);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This action "%d" is not allowed for the relay of module', $action)
            );
        }

        return $action;
    }

    /** @throws InvalidInputParameterException */
    public function validateInputAction(int $action): int
    {
        $validate = in_array($action, Common::POSSIBLE_INPUT_ACTIONS);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This action "%d" is not allowed for the module digital input', $action)
            );
        }

        return $action;
    }

    /** @throws InvalidInputParameterException */
    public function validateInterval(int $interval): int
    {
        $validate = ($interval >= Common::MIN_INTERVAL)
            && ($interval <= Common::MAX_INTERVAL);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This time interval "%d" is not allowed for the module', $interval)
            );
        }

        return $interval;
    }

    /** @throws InvalidInputParameterException */
    public function validateAntiBounce(int $antiBounce): int
    {
        $validate = ($antiBounce >= Common::MIN_ANTI_BOUNCE)
            && ($antiBounce <= Common::MAX_ANTI_BOUNCE);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This time interval "%d" is not allowed for the module', $antiBounce)
            );
        }

        return $antiBounce;
    }

    /** @throws InvalidInputParameterException */
    public function validateInput(int $inputNumber, ?string $moduleType = null): int
    {
        $moduleType = $moduleType ?? (string) $this->configuration->get('type');
        $validate = ModuleHardwareCapabilities::isInputNumberAllowedForModuleType($inputNumber, $moduleType);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This module digital input number "%d" is not available', $inputNumber)
            );
        }

        return $inputNumber;
    }

    /** @throws InvalidInputParameterException */
    public function validateRelayGroupControlData(string $data): string
    {
        if (hexdec($data) > 65535) {
            throw new InvalidInputParameterException(
                'The group relay control data must be in the range from "0000" to "ffff"'
            );
        }

        return $data;
    }

    /** @throws InvalidInputParameterException */
    public function validateRelay(int $relayNumber, ?string $moduleType = null): int
    {
        $moduleType = $moduleType ?? (string) $this->configuration->get('type');
        $validate = ModuleHardwareCapabilities::isRelayNumberAllowedForModuleType($relayNumber, $moduleType);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This module relay number "%d" is not available', $relayNumber)
            );
        }

        return $relayNumber;
    }

    /** @throws InvalidInputParameterException */
    public function validateHost(string $host): string
    {
        if (
            !(filter_var($host, FILTER_VALIDATE_IP)
                || filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME))
        ) {
            throw new InvalidInputParameterException(
                sprintf('Module host "%s" is not valid', $host)
            );
        }

        return $host;
    }

    /** @throws InvalidInputParameterException */
    public function validatePort(int $port): int
    {
        if ($port < 1024 || $port > 65535) {
            throw new InvalidInputParameterException(
                sprintf('Module TCP port number "%s" is not valid', $port)
            );
        }

        return $port;
    }

    /** @throws InvalidInputParameterException */
    public function validateType(string $type): string
    {
        if (!ModuleTypes::validateType($type)) {
            throw new InvalidInputParameterException(
                sprintf('Module type "%s" is not valid', $type)
            );
        }

        return $type;
    }

    /** @throws InvalidInputParameterException */
    public function validateTemperature(int $data, int $sign): int
    {
        $tempSign = $sign ? '-' : '+';

        if (ModuleHardwareCapabilities::isSocket3TemperatureOutOfRange($data, $sign)) {
            throw new InvalidInputParameterException(
                sprintf('Temperature "%s%d" out of range', $tempSign, $data)
            );
        }

        return $data;
    }

    /** @throws UnknownCommandException */
    public function validateResponse(Command $command, Response $response): bool
    {
        if (is_null($command->commandData)) {
            return $this->validateEventId($command->commandID->id, $response->getEventId());
        }
        if (ModuleCommandRegistry::isInputStatusCommandId($command->commandID->id)) {
            return $command->commandData->toString() === substr($response->dataToHexString(), 0, 2);
        }

        return $command->commandData->toString() === $response->dataToHexString()
            && $this->validateEventId($command->commandID->id, $response->getEventId());
    }
}
