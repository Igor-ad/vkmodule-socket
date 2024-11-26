<?php declare(strict_types=1);

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
    public function testGetContent(): void
    {
        $expected = 'data';
        $fileName = '_testFile';
        FileProcessor::putContent($fileName, $expected);
        $data = FileProcessor::getContent($fileName);

        $this->assertSame($expected, $data);

        unlink($fileName);

        $this->expectException(ModuleException::class);
        FileProcessor::getContent('testFile_');
    }

    public function testPutContent(): void
    {
        $expected = 'testFile';
        mkdir($expected, 644);

        $this->expectException(ModuleException::class);
        FileProcessor::putContent($expected, 'data');

        rmdir($expected);
    }
}
