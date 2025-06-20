#!/usr/bin/php
<?php

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;

if (!is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new LogicException(
        '/vendor/autoload.php is missing. Please run "composer install" under application root directory.'
    );
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

$port = (int)getByKey($argv, 1);
$timeout = (float)getByKey($argv, 2);

$tcpServerConnector = new TcpServerConnector('localhost', $port, $timeout);
$server = $tcpServerConnector->getConnector();
$tcpServerConnector->listenMirrored($server, $timeout);
