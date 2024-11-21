<?php declare(strict_types=1);

namespace Enums;

use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Commands::class)]
class CommandsTest extends TestCase
{
    public function testCommands(): void
    {
        $expected = ['01', '02', '03', '04', '0f', '30', '31', '32', '20',
            '21', '22', '23', '24', '41', '42', '43', '44', '25', '1f', '10'];
        $this->assertSame($expected, Commands::commands());
    }

    /**
     * @throws ModuleException
     */
    public function testDescription(): void
    {
        $expected = 'get_uid';
        $this->assertSame($expected, Commands::description('04'));
        $this->expectException(ModuleException::class);
        Commands::description('aa');
    }
}
