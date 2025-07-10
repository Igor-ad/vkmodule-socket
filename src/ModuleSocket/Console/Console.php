<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

use Autodoctor\ModuleSocket\Exceptions\ClassNotFoundException;

class Console
{
    protected ConsoleCommand $command;

    /**
     * @throws ClassNotFoundException
     */
    public function __construct(
        protected string $commandName,
        protected ?string $queryString,
    ) {
        $commandClassName = toPascalCase($commandName);
        $this->setCommand($commandClassName);
    }

    public function invoke(): mixed
    {
        return $this->command->execute($this->commandName, $this->queryString);
    }

    /**
     * @throws ClassNotFoundException
     */
    public static function make(string $commandName, ?string $queryString = ''): Console
    {
        return new self($commandName, $queryString);
    }

    /**
     * @throws ClassNotFoundException
     */
    public function setCommand($commandClassName): void
    {
        $commandClass = __NAMESPACE__ . '\\' . $commandClassName;

        if (!class_exists($commandClass)) {
            throw new ClassNotFoundException(
                sprintf('This command class: %s not found in the system.', $commandClass)
            );
        }
        $this->command = new $commandClass();
    }
}
