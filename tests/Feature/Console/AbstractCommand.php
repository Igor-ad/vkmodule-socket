<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

use Autodoctor\ModuleSocket\Enums\Files;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\ProxyLocalSocketServerInit;

abstract class AbstractCommand extends ProxyLocalSocketServerInit
{
    abstract public static function commandDataProvider(): array;

    protected function setOutgoingStream(string $outgoingStream): string
    {
        if (strlen($outgoingStream) % 2 !== 0) {
            throw new \InvalidArgumentException('The length of the hexadecimal string must be even.');
        }

        $outgoingStreamData = str_split($outgoingStream, 2);
        $byteCharacters = array_map(fn($hexPair) => chr(hexdec($hexPair)), $outgoingStreamData);

        return implode('', $byteCharacters);
    }

    #[DataProvider('commandDataProvider')]
    public function testCommand(
        string $command,
        string $queryString,
        string $outgoingStream,
        string $expectedString,
    ): void {
        $cli = Files::CliFile->getPath() . " '" . $command . "' '" . $queryString . "'";
        $output = [];
        $returnVar = 1;

        $this->proxyServerInit($this->setOutgoingStream($outgoingStream));
        exec($cli, $output, $returnVar);

        $logFile = file(Files::CliLogFile->getPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $actualString = $logFile[count($logFile) - 2];

        $this->assertEquals(0, $returnVar);
        $this->assertTrue(str_contains($actualString, $expectedString));
    }
}
