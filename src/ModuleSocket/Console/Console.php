<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Console
{
    protected ConsoleCommand $command;

    public function __construct(
        protected string $commandName,
        protected ?string $queryString,
    ) {
        $this->initCommand();
    }

    public function invoke(): int|string
    {
        return $this->command->execute($this->commandName, $this->queryString);
    }

    public static function make(string $commandName, ?string $queryString = ''): Console
    {
        return new self($commandName, $queryString);
    }

    private function initCommand(): void
    {
        $isCli = !str_contains($this->commandName, 'api_');

        $this->command = ConsoleCommandFactory::makeConsoleCommand($isCli);
    }

    public function setCommand(ConsoleCommand $command): void
    {
        $this->command = $command;
    }
}
