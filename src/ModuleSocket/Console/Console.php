<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

class Console
{
    protected ConsoleCommand $command;
    protected ConsoleMode $mode;

    public function __construct(
        protected string $commandName,
        protected ?string $queryString,
        ?ConsoleMode $mode = null,
    ) {
        $this->mode = $mode ?? ConsoleMode::fromCommandName($commandName);
        $this->initCommand();
    }

    public function invoke(): int|string
    {
        return $this->command->execute($this->commandName, $this->queryString);
    }

    public static function make(string $commandName, ?string $queryString = '', ?ConsoleMode $mode = null): Console
    {
        return new self($commandName, $queryString, $mode);
    }

    public function mode(): ConsoleMode
    {
        return $this->mode;
    }

    private function initCommand(): void
    {
        $this->command = ConsoleCommandFactory::makeConsoleCommand($this->mode === ConsoleMode::Cli);
    }

    public function setCommand(ConsoleCommand $command): void
    {
        $this->command = $command;
    }
}
