<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Connectors;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;

class FileConnector implements Connector
{
    /**
     * @var resource $connector
     */
    protected $connector;

    /**
     * @throws ModuleException
     */
    public function __construct(string $fileName, string $mode = 'ab+')
    {
        $this->setConnector($fileName, $mode);
    }

    /**
     * @throws ModuleException
     */
    protected function setConnector(string $fileName, string $mode): void
    {
        $this->connector = fopen($fileName, $mode);

        if ($this->connector === false) {
            throw new ModuleException(sprintf('Error opening file: %s.', $fileName));
        }
    }

    public function getConnector()
    {
        return $this->connector;
    }

    public function __destruct()
    {
        fclose($this->connector);
        $this->connector = false;
    }
}
