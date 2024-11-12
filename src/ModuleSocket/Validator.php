<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\Enums\Common;
use Autodoctor\ModuleSocket\Enums\Socket1;
use Autodoctor\ModuleSocket\Enums\Socket2;
use Autodoctor\ModuleSocket\Enums\Socket3;
use Autodoctor\ModuleSocket\Enums\Socket4;
use Autodoctor\ModuleSocket\Enums\Socket5;
use Autodoctor\ModuleSocket\Enums\SocketGiant;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;

class Validator
{
    use ValidateHandler;

    public const VALID_MODULE_TYPES = [
        Socket1::TYPE,
        Socket2::TYPE,
        Socket3::TYPE,
        Socket4::TYPE,
        Socket5::TYPE,
        SocketGiant::TYPE,
    ];

    private static ?Validator $instance = null;

    private function __construct() {}

    public static function instance(): self
    {
        self::$instance = self::$instance ?? new self();

        return self::$instance;
    }

    /**
     * @throws InvalidRequestCommandException
     */
    public function validateModuleCommandId(string $commandId, string $moduleType = null): bool
    {
        $validate = in_array($commandId, $this->getCommandIdRule($moduleType), true);

        if ($validate === false) {
            throw new InvalidRequestCommandException(
                sprintf('This command id: "%s" is not supported by controllers.', $commandId)
            );
        }
        return true;
    }

    /**
     * @throws UnknownCommandException
     */
    public function validateEventId(Command $command, Response $response): bool
    {
        return match ($response->id) {
            Socket1::SET_INPUT,
            Socket2::SET_INPUT,
            $command->ID->id => true,
            Common::UNKNOWN => throw new UnknownCommandException(
                'An unknown (not supported by this controller) command was received'
                . ' or the command parameters are not set correctly.'
            ),
            default => false,
        };
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateRelayAction(int $action): int
    {
        $validate = in_array($action, Common::POSSIBLE_RELAY_ACTIONS);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This action: "%d" is not allowed for the relay of module', $action)
            );
        }
        return $action;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateInputAction(int $action): int
    {
        $validate = in_array($action, Common::POSSIBLE_INPUT_ACTIONS);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This action: "%d" is not allowed for the module digital input.', $action)
            );
        }
        return $action;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateInterval(int $interval): int
    {
        $validate = ($interval >= Common::MIN_INTERVAL)
            && ($interval <= Common::MAX_INTERVAL);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This time interval: "%d" is not allowed for the module', $interval)
            );
        }
        return $interval;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateAntiBounce(int $antiBounce): int
    {
        $validate = ($antiBounce >= Common::MIN_ANTI_BOUNCE)
            && ($antiBounce <= Common::MAX_ANTI_BOUNCE);

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This time interval: "%d" is not allowed for the module', $antiBounce)
            );
        }
        return $antiBounce;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateInput(int $inputNumber, string $moduleType = null): int
    {
        $validate = in_array($inputNumber, $this->getInputRule($moduleType));

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This module digital input number: "%d" is not available', $inputNumber)
            );
        }
        return $inputNumber;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateRelayGroupControlData(string $data): string
    {
        if (hexdec($data) > 65535) {
            throw new InvalidInputParameterException(
                'The group relay control data must be in the range from "0000" to "ffff".'
            );
        }
        return $data;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateRelay(int $relayNumber, string $moduleType = null): int
    {
        $validate = in_array($relayNumber, $this->getRelayRule($moduleType));

        if ($validate === false) {
            throw new InvalidInputParameterException(
                sprintf('This module relay number: "%d" is not available', $relayNumber)
            );
        }
        return $relayNumber;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateHost(string $host): string
    {
        if (!(
            filter_var($host, FILTER_VALIDATE_IP)
            || filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)
        )) {
            throw new InvalidInputParameterException(
                sprintf('Module address: %s is not valid.', $host)
            );
        }
        return $host;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validatePort(int $port): int
    {
        if ($port < 999 || $port > 65535) {
            throw new InvalidInputParameterException(
                sprintf('Module TCP port number: %s is not valid.', $port)
            );
        }
        return $port;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateType(string $type): string
    {
        if (!in_array($type, self::VALID_MODULE_TYPES, true)) {
            throw new InvalidInputParameterException(
                sprintf('Module type: %s is not valid.', $type)
            );
        }
        return $type;
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function validateTemperature(int $data, int $sensorNumber, int $sign): int
    {
        $tempSign = $sign ? '-' : '+';

        if ($data > Socket3::MAX_TEMPERATURE || (($data > Socket3::NEG_MIN_TEMPERATURE) && $sign)) {
            throw new InvalidInputParameterException(
                sprintf('Temperature: %s%d of sensor number "%d" out of range.', $tempSign, $data, $sensorNumber)
            );
        }
        return $data;
    }

    /**
     * @throws UnknownCommandException
     */
    public function validateResponse(Command $command, Response $response): bool
    {
        if (is_null($command->commandData)) {
            return Validator::instance()->validateEventId($command, $response);
        }
        if ($command->ID->id === Commands::GET_INPUT->value
            || $command->ID->id === Commands::SOCKET1_GET_INPUT->value) {
            return $command->commandData->toString() === substr($response->dataToHexString(), 0, 2);
        }
        return $command->commandData->toString() === $response->dataToHexString()
            && Validator::instance()->validateEventId($command, $response);
    }
}
