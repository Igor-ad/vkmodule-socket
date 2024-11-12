#!/usr/bin/php
<?php

declare(strict_types=1);

use Autodoctor\ModuleSocket\Console\Console;
use Autodoctor\ModuleSocket\Exceptions\ClassNotFoundException;

require __DIR__ . '/../vendor/autoload.php';

try {
    $controlCommand = Console::make(
        commandName: getByKey($argv, 1),
        queryString: getByKey($argv, 2)
    );
    return $controlCommand->invoke();
} catch (ClassNotFoundException $e) {
    echo $e->getMessage();
}
