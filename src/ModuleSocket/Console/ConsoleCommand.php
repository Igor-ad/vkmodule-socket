<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Console;

interface ConsoleCommand
{
    public function execute(string $queryString): int|string;
}
