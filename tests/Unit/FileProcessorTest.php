<?php

declare(strict_types=1);

namespace Tests\Unit;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use Autodoctor\ModuleSocket\FileProcessor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileProcessor::class)]
class FileProcessorTest extends TestCase
{
    /**
     * @throws ModuleException
     */
    public function testGetPutContent(): void
    {
        $expected = 'data';
        $fileName = tempnam('/tmp', '_');
        FileProcessor::putContent($fileName, $expected);
        $data = FileProcessor::getContent($fileName);

        $this->assertSame($expected, $data);
        unlink($fileName);
    }

    public function testGetContentException(): void
    {
        $this->expectException(ModuleException::class);
        @FileProcessor::getContent('test');
    }

    public function testPutContentException(): void
    {
        $this->expectException(ModuleException::class);
        @FileProcessor::putContent(__DIR__, 'data');
    }
}
