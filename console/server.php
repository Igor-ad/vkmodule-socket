#!/usr/bin/php
<?php

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerListener;
use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;

if (!is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new LogicException(
        '/vendor/autoload.php is missing. Please run "composer install" under application root directory.'
    );
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

$tcpServerConnector = new TcpServerConnector('localhost', 9761);
$server = $tcpServerConnector->getConnector();

while ($listener = TcpServerListener::instance($server, 5)->getConnector()) {
    $inputStream = fread($listener, 32);
    fwrite($listener, $inputStream);
    fclose($listener);
}
