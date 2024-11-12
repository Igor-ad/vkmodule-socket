<?php

declare(strict_types=1);

use Autodoctor\ModuleSocket\Console\Console;
use Autodoctor\ModuleSocket\Exceptions\ClassNotFoundException;

require __DIR__ . '/../vendor/autoload.php';

$queryString = getValue($_REQUEST, 'query');
$command = getValue($_REQUEST, 'cmd');

try {
    $controlCommand = Console::make(
        commandName: $command,
        queryString: $queryString
    );
    echo $controlCommand->invoke();
} catch (ClassNotFoundException $e) {
    echo $e->getMessage();
}
