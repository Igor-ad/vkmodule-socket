<?php

declare(strict_types=1);

/**
 * CLI helper: connect to 127.0.0.1:PORT and write one byte (argv[1]=port, argv[2]=hex byte, default 01).
 * Used by {@see TcpServerConnectorTest} via proc_open so {@see TcpServerConnector::listenOnce} can accept.
 */
$port = (int) ($argv[1] ?? 0);
$hex = $argv[2] ?? '01';
if ($port < 1 || strlen($hex) !== 2) {
    fwrite(STDERR, "usage: TcpOneShotClient.php PORT [HEXPAIR]\n");
    exit(2);
}

$uri = 'tcp://127.0.0.1:' . $port;
$socket = @stream_socket_client($uri, $errno, $errstr, 5.0);
if ($socket === false) {
    fwrite(STDERR, "connect failed: $errstr ($errno)\n");
    exit(3);
}

fwrite($socket, chr(hexdec($hex)));
fclose($socket);
