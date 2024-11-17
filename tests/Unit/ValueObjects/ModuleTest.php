<?php

declare(strict_types=1);

namespace ValueObjects;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ModuleTest extends TestCase
{
    /**
     * @throws InvalidInputParameterException
     */
    public function moduleInit(): Module
    {
        return new Module('localhost', 1111, 'Socket-1');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function test__construct(): void
    {
        $this->assertTrue(is_a($this->moduleInit(), Module::class));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToJson(): void
    {
        $expected = '{"module":{"host":"localhost","port":1111,"type":"Socket-1"}}';
        $this->assertSame($expected, $this->moduleInit()->toJson());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testIsEqual(): void
    {
        $anotherModule = new Module('localhost', 1111, 'Socket-1');
        $this->assertTrue($this->moduleInit()->isEqual($anotherModule));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testToArray(): void
    {
        $expected = [
            'module' => [
                'host' => 'localhost',
                'port' => 1111,
                'type' => 'Socket-1',
            ]
        ];
        $this->assertSame($expected, $this->moduleInit()->toArray());
    }

    public function testAcceptedDefaultModuleConfig(): void
    {
        $this->assertTrue(is_a(new Module(), Module::class));
    }

    public function testModuleClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Module::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
