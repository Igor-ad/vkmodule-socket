<?php declare(strict_types=1);

use Autodoctor\ModuleSocket\Configurator;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Configurator::class)]
class ConfiguratorTest extends TestCase
{
    protected array $config;

    public function test__construct(): void
    {
        $method = new ReflectionMethod(Configurator::class, '__construct');

        $this->assertTrue($method->isPrivate());
    }

    /**
     * @throws ConfiguratorException
     */
    public function testInstance(): void
    {
        $configurator = Configurator::instance();

        $this->assertInstanceOf(Configurator::class, $configurator);
    }

    /**
     * @throws ConfiguratorException
     */
    public function testGet(): void
    {
        $value = Configurator::instance()->get('');

        $this->assertTrue(is_null($value));

        $value = Configurator::instance()->get('port');

        $this->assertTrue($value === 9761);
    }


    /**
     * @throws ReflectionException
     * @throws ConfiguratorException
     * @throws ModuleException
     */
    public function testSetConfig(): void
    {
        $object = Configurator::instance();

        $this->assertNotNull($object);

        $method = new ReflectionMethod($object, 'setConfig');

        $this->assertTrue($method->isPrivate());

        $this->expectException(ConfiguratorException::class);
        $method->invoke($object, Configurator::CONFIG_FILE);
    }

    /**
     * @throws ConfiguratorException
     */
    public function testUniqueness(): void
    {
        $expected = Configurator::class;
        $firstInstance = Configurator::instance();

        $this->assertNotNull($firstInstance);
        $this->assertInstanceOf($expected, $firstInstance);

        $secondInstance = Configurator::instance();

        $this->assertNotNull($secondInstance);
        $this->assertInstanceOf($expected, $secondInstance);
        $this->assertEquals($firstInstance, $secondInstance);
    }
}