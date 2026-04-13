<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use Autodoctor\ModuleSocket\Validation\ValidatorInterface;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractService implements LoggerAwareInterface, Service
{
    use LoggerAwareTrait;

    public function __construct(
        protected Transceiver $transceiver,
        protected ValidatorInterface $validator,
    ) {
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    abstract public function getResponse(Command $command): Response;

    /** @throws UnknownCommandException */
    protected function call(Command $command): \Closure
    {
        return function () use ($command) {
            $this->transceiver->setStreamData($command->toStream());
            $this->transceiver->write($this->transceiver->getStreamData());
            $response = Response::getDto($this->transceiver->getStreamContent());
            $response->success = $this->isSuccess($command, $response);

            return $response;
        };
    }

    /** @throws UnknownCommandException */
    protected function isSuccess(Command $command, Response $response): bool
    {
        return $this->validator->validateResponse($command, $response);
    }

    protected function log(Command $command, Response $response): void
    {
        if ($this->logger === null) {
            return;
        }

        $this->logger->debug(
            'Response: ' . $response->toJson(),
            [
                'CommandToJson: ' . $command->toJson(),
                'HexCommandData: ' . $command->commandData?->toString()
            ]
        );
    }
}
