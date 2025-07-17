<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors\Clients;

use Autodoctor\ModuleSocket\Connectors\Clients\HttpConnector;
use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HttpConnector::class)]
class HttpConnectorTest extends TestCase
{
    protected HttpConnector $connector;

    protected function setUp(): void
    {
        $this->connector = new HttpConnector('google.com');
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(HttpConnector::class, $this->connector);
    }

    public function testGetConnector(): void
    {
        $this->assertInstanceOf(Client::class, $this->connector->getConnector());
    }
}
