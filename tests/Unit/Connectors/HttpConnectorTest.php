<?php declare(strict_types=1);

namespace Connectors;

use Autodoctor\ModuleSocket\Connectors\HttpConnector;
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

    public function test__construct(): void
    {
        $this->assertInstanceOf(HttpConnector::class, $this->connector);
    }

    public function testGetConnector(): void
    {
        $this->assertInstanceOf(Client::class, $this->connector->getConnector());
    }
}
