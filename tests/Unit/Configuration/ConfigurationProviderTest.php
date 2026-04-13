<?php

declare(strict_types=1);

namespace Tests\Unit\Configuration;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigurationProvider::class)]
class ConfigurationProviderTest extends TestCase
{
    protected string $testConfigFile;

    protected string $sampleJsonFile;

    public function setUp(): void
    {
        parent::setUp();

        $this->testConfigFile = Files::TestConfigFile->getPath();
        $this->sampleJsonFile = dirname($this->testConfigFile) . DIRECTORY_SEPARATOR . 'sample.json';
    }

    public function testfromConfigFile(): void
    {
        $configuration = ConfigurationProvider::fromConfigFile($this->testConfigFile);

        $this->assertInstanceOf(ConfigurationProvider::class, $configuration);
    }

    public function testGetfromConfigFile(): void
    {
        $configuration = ConfigurationProvider::fromConfigFile($this->testConfigFile);

        $this->assertNull($configuration->get(''));

        $this->assertSame(9761, $configuration->get('port'));
        $this->assertSame('127.0.0.1', $configuration->get('host'));
    }

    public function testFromJsonFile(): void
    {
        $configuration = ConfigurationProvider::fromJsonFile($this->sampleJsonFile);

        $this->assertSame('127.0.0.1', $configuration->get('host'));
        $this->assertSame(9999, $configuration->get('port'));
        $this->assertSame('Socket-1', $configuration->get('type'));
    }

    public function testfromConfigFileMissingThrows(): void
    {
        $this->expectException(ConfiguratorException::class);
        ConfigurationProvider::fromConfigFile(__DIR__ . '/nonexistent_config.php');
    }

    public function testFromConfigFileNonArrayReturnThrows(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'vk_cfg_');
        $this->assertNotFalse($path);
        file_put_contents($path, '<?php return 1;');

        try {
            $this->expectException(ConfiguratorException::class);
            $this->expectExceptionMessage('Error reading configuration.');
            ConfigurationProvider::fromConfigFile($path);
        } finally {
            unlink($path);
        }
    }

    public function testFromJsonFileInvalidJsonThrows(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'vk_json_');
        $this->assertNotFalse($path);
        file_put_contents($path, "{not-valid-json");

        try {
            $this->expectException(ConfiguratorException::class);
            $this->expectExceptionMessage('Invalid JSON configuration:');
            ConfigurationProvider::fromJsonFile($path);
        } finally {
            unlink($path);
        }
    }

    public function testInstancesAreNotSingleton(): void
    {
        $first = ConfigurationProvider::fromConfigFile($this->testConfigFile);
        $second = ConfigurationProvider::fromConfigFile($this->testConfigFile);

        $this->assertNotSame($first, $second);
        $this->assertSame($first->get('port'), $second->get('port'));
    }
}
