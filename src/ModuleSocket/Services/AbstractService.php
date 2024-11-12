<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Services;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;
use Autodoctor\ModuleSocket\Transceivers\Transceiver;
use Autodoctor\ModuleSocket\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractService implements LoggerAwareInterface, Service
{
    use LoggerAwareTrait;

    public function __construct(
        protected Transceiver $transceiver,
    ) {}

    abstract public function getResponse(Command $command): Response;

    protected function call(Command $command): \Closure
    {
        return function () use ($command) {
            $this->transceiver->setStreamData($command->toStream());
            $response = Response::getDto($this->transceiver->processing());
            $response->success = $this->isSuccess($command, $response);

            return $response;
        };
    }

    /**
     * @throws UnknownCommandException
     */
    protected function isSuccess(Command $command, Response $response): bool
    {
        return Validator::instance()->validateResponse($command, $response);
    }

    protected function log(Command $command, Response $response): void
    {
        $this->logger->debug(
            'Response: ' . $response->toJson(),
            [
                'CommandToJson: ' . $command->toJson(),
                'HexCommandData: ' . $command->commandData?->toString()
            ]
        );
    }
}
