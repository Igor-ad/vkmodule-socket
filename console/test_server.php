#!/usr/bin/env php
<?php

declare(strict_types=1);

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;

if (!is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new LogicException(
        '/vendor/autoload.php is missing. Please run "composer install" under application root directory.'
    );
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

$port = (int) getByKey($argv, 1);
$timeout = (float) getByKey($argv, 2);
$outgoingStream = getByKey($argv, 3);

$decoded = base64_decode((string) $outgoingStream, true);
if ($decoded === false) {
    throw new InvalidArgumentException('Invalid base64 outbound stream.');
}

$tcpServerConnector = new TcpServerConnector('127.0.0.1', $port, $timeout);
$server = $tcpServerConnector->getConnector();

while (is_resource($server)) {
    if (!$tcpServerConnector->listenOnce($server, $timeout, $decoded)) {
        usleep(50_000);
    }
}
