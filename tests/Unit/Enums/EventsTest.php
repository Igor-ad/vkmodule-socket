<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Autodoctor\ModuleSocket\Enums\Events;
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

    public function testDescription(): void
    {
        $expected = 'Socket1GetInput';

        $this->assertSame($expected, Events::description('30'));

        $expected = 'Socket1InputStatusChanged';

        $this->assertSame($expected, Events::descriptionAutoGenerateEvent('31'));

        $expected = 'GetInput';

        $this->assertSame($expected, Events::description('20'));

        $expected = 'InputStatusChanged';

        $this->assertSame($expected, Events::descriptionAutoGenerateEvent('21'));
    }
}
