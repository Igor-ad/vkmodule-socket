<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors\Servers;

use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerConnector;
use Autodoctor\ModuleSocket\Connectors\Servers\TcpServerListener;
use PHPUnit\Framework\TestCase;

class TcpServerListenerTest extends TestCase
{
    protected $server;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = new TcpServerConnector('localhost', 9761);
    }

    public function test__construct(): void
    {
        $connector = TcpServerListener::instance($this->server, 5);

        $this->assertInstanceOf($connector::class, TcpServerListener::class);
    }
}
