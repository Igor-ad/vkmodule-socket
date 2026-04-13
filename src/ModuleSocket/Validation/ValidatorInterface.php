<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Validation;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;

interface ValidatorInterface
{
    /**
     * @throws InvalidRequestCommandException
     */
    public function validateModuleCommandId(string $commandId, ?string $moduleType = null): bool;

    /**
     * @throws UnknownCommandException
     */
    public function validateEventId(string $commandId, string $responseId): bool;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateRelayAction(int $action): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateInputAction(int $action): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateInterval(int $interval): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateAntiBounce(int $antiBounce): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateInput(int $inputNumber, ?string $moduleType = null): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateRelayGroupControlData(string $data): string;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateRelay(int $relayNumber, ?string $moduleType = null): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateHost(string $host): string;

    /**
     * @throws InvalidInputParameterException
     */
    public function validatePort(int $port): int;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateType(string $type): string;

    /**
     * @throws InvalidInputParameterException
     */
    public function validateTemperature(int $data, int $sign): int;

    /**
     * @throws UnknownCommandException
     */
    public function validateResponse(Command $command, Response $response): bool;
}
