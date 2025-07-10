#!/usr/bin/php
<?php

declare(strict_types=1);

use Autodoctor\ModuleSocket\Console\Console;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ExceptionHandler;
use Autodoctor\ModuleSocket\Logger\Logger;

if (!is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new LogicException(
        '/vendor/autoload.php is missing. Please run "composer install" under application root directory.'
    );
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

$logger = new Logger(Files::CliLogFile->getPath());

$handler = new ExceptionHandler(true);

$handler->setLogger($logger);
$handler->register();

$command = getByKey($argv, 1);
$queryString = getByKey($argv, 2);

$controlCommand = Console::make(
    commandName: $command,
    queryString: $queryString,
);

if ((!str_contains($command, 'api_'))) {
    return $controlCommand->invoke();
} else {
    print $controlCommand->invoke();
}
