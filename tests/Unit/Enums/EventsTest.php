<?php declare(strict_types=1);

namespace Enums;

use Autodoctor\ModuleSocket\Enums\Events;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Events::class)]
class EventsTest extends TestCase
{
    public function testEvents(): void
    {
        $expected = ['01', '02', '03', '04', '0f', '30', '31', '32', '20', '21', '22',
            '23', '24', '41', '42', '43', '44', '25', '1f', '10', '1c', '1b', '1d', '1e'];

        $this->assertSame($expected, Events::events());
    }

    /**
     * @throws ModuleException
     */
    public function testDescription(): void
    {
        $expected = 'socket1_input_status_changed';

        $this->assertSame($expected, Events::description('31', '30'));

        $expected = 'input_status_changed';

        $this->assertSame($expected, Events::description('21', '20'));

        $this->expectException(ModuleException::class);
        Events::description('aa', 'bb');
    }
}
