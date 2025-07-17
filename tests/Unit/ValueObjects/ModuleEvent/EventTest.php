<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\ModuleEvent;

use Autodoctor\ModuleSocket\ValueObjects\ModuleEvent\Event;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Event::class)]
class EventTest extends TestCase
{
    public function testConstruct(): void
    {
        $expectedEvent = new Event('01', null);

        $this->assertInstanceOf(Event::class, $expectedEvent);
    }

    public function testToArray(): void
    {
        $expected = [
            'event' => [
                'id' => '03',
                'description' => 'GetFirmware',
                'data' => ['04', '01', '09', '07'],
            ]
        ];

        $actual = (new Event('03', ['04', '01', '09', '07']))->toArray();

        $this->assertSame($expected, $actual);
    }

    public function testIsEqual(): void
    {
        $expected = (new Event('03', ['04', '01', '09', '07']));
        $actual = (new Event('03', ['04', '01', '09', '07']));

        $this->assertTrue($actual->isEqual($expected));
    }
}
