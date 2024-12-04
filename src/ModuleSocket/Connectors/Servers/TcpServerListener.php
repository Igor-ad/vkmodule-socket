<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors\Servers;

use Autodoctor\ModuleSocket\Connectors\Connector;

class TcpServerListener implements Connector
{
    /**
     * @var resource
     */
    protected $connector;

    /**
     * @param resource $server
     */
    public function __construct($server, ?float $timeout = null)
    {
        $this->connector = stream_socket_accept($server, $timeout);
    }

    /**
     * @return false|resource
     */
    public function getConnector()
    {
        return $this->connector;
    }

    public static function instance($server, float $timout): self
    {
        return new static($server, $timout);
    }

    public function __destruct()
    {
        $this->connector = false;
    }
}
