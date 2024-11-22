#!/usr/bin/php
<?php

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerListener;
use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;

require __DIR__ . '/../vendor/autoload.php';

$tcpServerConnector = new TcpServerConnector('localhost');
$server = $tcpServerConnector->getConnector();

while ($listener = TcpServerListener::instance($server)->getConnector()) {
    $inputStream = fread($listener, 32);
    fwrite($listener, $inputStream);
    fclose($listener);
}
