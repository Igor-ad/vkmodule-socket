<?php declare(strict_types=1);

namespace Tests\Unit\DTO;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(Request::class)]
class RequestTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $command = __DIR__ . "/../../../console/server.php >/dev/null 2>&1 &";
        exec($command);
    }

    protected function tearDown(): void
    {
        gc_collect_cycles();
    }

    public static function requestDataProvider(): array
    {
        return [
            ['{"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"01"},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"02"},"connector":{"timeOut":3,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"03"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"04"},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}'],
            ['{"command":{"id":"20","data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"21","data":{"input":{"inputNumber":0}}},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"22","data":{"relay":{"relayNumber":0,"action":1,"interval":30}}},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"23"},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"24"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"25","data":{"relayGroup":{"relayGroupAction":"ffff"}}},"connector":{"type":"TCP","timeOut":3},"module":{"ip":"localhost","port":9761,"type":"Socket-Giant"}}'],
            ['{"command":{"id":"30","data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"31","data":{"input":{"inputNumber":0}}},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"32"},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"41"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"42"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"43","data":{"relay":{"relayNumber":1,"action":1,"interval":50}}},"connector":{"type":"TCP","timeOut":10},"module":{"ip":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"44"},"connector":{"timeOut":10,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
        ];
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     */
    #[DataProvider('requestDataProvider')]
    public function test__construct(string $queryString): void
    {
        $request = new Request($queryString);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertTrue(is_a($request->command, Command::class) || is_null($request->command));
        $this->assertInstanceOf(Connector::class, $request->connector);
        $this->assertInstanceOf(Module::class, $request->module);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws InvalidRequestCommandException
     * @throws ConfiguratorException
     */
    #[DataProvider('requestDataProvider')]
    public function testCommand(string $queryString): void
    {
        $request = new Request($queryString);

        $this->assertSame(getValue($request->request, 'command.id'), $request->command->ID->id);
        $this->assertSame(getValue($request->request, 'command.data'), $request->command->commandData?->toArray());
    }

    #[CoversNothing]
    public function testResponseClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Request::class);

        $this->assertTrue($reflectionClass->isFinal());
    }
}
