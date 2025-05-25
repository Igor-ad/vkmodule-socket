<?php

declare(strict_types=1);

namespace Tests\Unit\Connectors;

use Autodoctor\ModuleSocket\Connectors\FileConnector;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use PHPUnit\Framework\TestCase;

class FileConnectorTest extends TestCase
{
    /**
     * @throws ModuleException
     */
    public function test__construct(): void
    {
        $fileName = tempnam('/tmp', '_');

        $this->assertInstanceOf(expected: FileConnector::class, actual: new FileConnector($fileName, 'r'));

        unlink($fileName);
    }

    public function testSetConnectorException(): void
    {
        $this->expectException(ModuleException::class);
        @ new FileConnector('./test.txt', 'r');
    }

    public function testGetConnector(): void
    {
        $fileName = tempnam('/tmp', '_');
        $connector = (new FileConnector($fileName))->getConnector();

        $this->assertIsResource($connector);

        unlink($fileName);
    }
}
