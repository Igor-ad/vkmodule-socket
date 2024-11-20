<?php

declare(strict_types=1);

namespace ValueObjects;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ModuleTest extends TestCase
{
    protected Module $module;

    /**
     * @throws InvalidInputParameterException
     */
    protected function setUp(): void
    {
        $this->module = new Module('localhost', 9761, 'Socket-1');
    }

    public function test__construct(): void
    {
        $this->assertInstanceOf(Module::class, $this->module);
    }

    public function testToJson(): void
    {
        $expected = '{"module":{"host":"localhost","port":9761,"type":"Socket-1"}}';
        $this->assertSame($expected, $this->module->toJson());
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testIsEqual(): void
    {
        $anotherModule = new Module('localhost', 9761, 'Socket-1');
        $this->assertTrue($this->module->isEqual($anotherModule));
    }

    public function testToArray(): void
    {
        $expected = [
            'module' => [
                'host' => 'localhost',
                'port' => 9761,
                'type' => 'Socket-1',
            ]
        ];
        $this->assertSame($expected, $this->module->toArray());
    }

    public function testAcceptedDefaultModuleConfig(): void
    {
        $this->assertInstanceOf(Module::class, new Module());
    }

    public function testModuleClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Module::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
