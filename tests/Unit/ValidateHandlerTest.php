<?php

declare(strict_types=1);

namespace Tests\Unit;

use Autodoctor\ModuleSocket\Validator;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class ValidateHandlerTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testGetCommandIdRule(): void
    {
        $object = Validator::instance();
        $method = new \ReflectionMethod($object, 'getCommandIdRule');

        $expected = ['01', '02', '03', '04', '30', '31', '32'];

        $this->assertSame($expected, $method->invoke($object, 'Socket-1'));

        $expected = ['01', '02', '03', '04', '20', '21', '22', '23', '24'];

        $this->assertSame($expected, $method->invoke($object, 'Socket-2'));

        $expected = ['01', '02', '03', '04', '41', '42', '43', '44'];

        $this->assertSame($expected, $method->invoke($object, 'Socket-3'));

        $expected = ['01', '02', '03', '04', '22', '23'];

        $this->assertSame($expected, $method->invoke($object, 'Socket-4'));

        $expected = ['01', '02', '03', '04', '20', '21', '22', '23'];

        $this->assertSame($expected, $method->invoke($object, 'Socket-5'));

        $expected = ['01', '02', '03', '04', '20', '21', '22', '23', '25'];

        $this->assertSame($expected, $method->invoke($object, 'Socket-Giant'));

        $expected = [];

        $this->assertSame($expected, $method->invoke($object, ''));
    }
}
