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

$logger = new Logger(Files::ApiLogFile->getPath());

$handler = new ExceptionHandler(false);
$handler->setLogger($logger);
$handler->register();

$command = getValue($_REQUEST, 'cmd');
$queryString = getValue($_REQUEST, 'query');

$controlCommand = Console::make(
    commandName: $command,
    queryString: $queryString,
);
echo $controlCommand->invoke();
