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
$outgoingStream = getByKey($argv, 3);

$tcpServerConnector = new TcpServerConnector('localhost', $port, $timeout);
$server = $tcpServerConnector->getConnector();
// base64_decode() - the hack to overcome passing null bytes as an argument
$tcpServerConnector->listenOnce($server, $timeout, base64_decode($outgoingStream));
