<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors\Servers;

class TcpServerListener
{
    /**
     * @var resource
     */
    protected $connector;

    /**
     * @param resource $server
     */
    public function __construct($server)
    {
        $this->connector = stream_socket_accept($server);
    }

    /**
     * @return false|resource
     */
    public function getConnector()
    {
        return $this->connector;
    }

    public static function instance($server): self
    {
        return new static($server);
    }

    public function __destruct()
    {
        $this->connector = false;
    }
}
