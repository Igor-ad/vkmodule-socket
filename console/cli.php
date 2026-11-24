#!/usr/bin/php
<?php

declare(strict_types=1);

use Autodoctor\ModuleSocket\Console\Console;
use Autodoctor\ModuleSocket\Console\ConsoleMode;
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

$isJson = in_array('--json', $argv, true);
$arguments = array_values(array_filter($argv, fn (string $argument) => $argument !== '--json'));

$command = getByKey($arguments, 1);
$queryString = getByKey($arguments, 2);

$mode = $isJson ? ConsoleMode::Api : ConsoleMode::fromCommandName($command);

$result = Console::make(
    commandName: $command,
    queryString: $queryString,
    mode: $mode,
)->invoke();

if ($mode === ConsoleMode::Api) {
    print $result;
}
