<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Module::class)]
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

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Module::class, $this->module);
        $this->assertSame('localhost', $this->module->host);
        $this->assertSame(9761, $this->module->port);
        $this->assertSame('Socket-1', $this->module->type);
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

        $this->expectException(InvalidInputParameterException::class);
        new Module('', 9761, '');
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
}
