<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Request::class)]
class RequestTest extends TestCase
{
    use RequestDataProvider;

    private ConfigurationProvider $testConfiguration;

    private Validator $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->testConfiguration = ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath());
        $this->validator = new Validator($this->testConfiguration);
    }

    public static function requestDataProviderOfModule(): array
    {
        return array_merge(
            [[
                'command' => 'reboot',
                'queryString' => '{"module":{"host":"127.0.0.1","port":9761,"type":"Socket-1"}}',
            ]],
            self::requestDataProvider(),
        );
    }

    #[DataProvider('requestDataProviderOfModule')]
    public function testConstruct(string $command, string $queryString): void
    {
        $request = Request::fromInput($command, $queryString, $this->testConfiguration, $this->validator);

        $this->assertInstanceOf(Request::class, $request);
    }

    #[DataProvider('requestDataProviderOfModule')]
    public function testConfigurationAndValidatorAccessors(string $command, string $queryString): void
    {
        $request = Request::fromInput($command, $queryString, $this->testConfiguration, $this->validator);

        $this->assertSame($this->testConfiguration, $request->configuration());
        $this->assertSame($this->validator, $request->validator());
    }

    #[DataProvider('requestDataProvider')]
    public function testMakeCommand(string $command, string $queryString): void
    {
        $request = Request::fromInput($command, $queryString, $this->testConfiguration, $this->validator);
        $module = $request->makeModule($request->request);
        $moduleCommandId = $request->resolveNameToCommandId($request->commandName, $module->type)
            ?? getValue($request->request, 'command.id');

        $this->assertInstanceOf(Command::class, $request->makeCommand(
            $module->type,
            $moduleCommandId,
            getValue($request->request, 'command.data'),
        ));
    }

    #[DataProvider('requestDataProviderOfModule')]
    public function testMakeModule(string $command, string $queryString): void
    {
        $request = Request::fromInput($command, $queryString, $this->testConfiguration, $this->validator);

        $this->assertInstanceOf(Module::class, $request->makeModule($request->request));
    }
}
