<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Request::class)]
class RequestTest extends TestCase
{
    use RequestDataProvider;

    public static function requestDataProviderOfModule(): array
    {
        return array_merge(
            [[
                'command' => 'reboot',
                'queryString' => '{"module":{"host":"localhost","port":9761,"type":"Socket-1"}}',
            ]],
            self::requestDataProvider(),
        );
    }

    #[DataProvider('requestDataProviderOfModule')]
    public function test__construct(string $command, string $queryString): void
    {
        $request = new Request($command, $queryString);

        $this->assertInstanceOf(Request::class, $request);
    }

    #[DataProvider('requestDataProvider')]
    public function testMakeCommand(string $command, string $queryString): void
    {
        $request = new Request($command, $queryString);
        $module = $request->makeModule($request->request);
        $moduleCommandId = $request->resolveNameToCommandId($request->commandName, $module->type)
            ?? getValue($request->request, 'command.id');

        $this->assertInstanceOf(Command::class, $request->makeCommand(
            $module->type,
            $moduleCommandId,
            getValue($request->request, 'command.data'),
        ));
    }

    /**
     * @throws InvalidInputParameterException
     */
    #[DataProvider('requestDataProviderOfModule')]
    public function testMakeModule(string $command, string $queryString): void
    {
        $request = new Request($command, $queryString);

        $this->assertInstanceOf(Module::class, $request->makeModule($request->request));
    }
}
