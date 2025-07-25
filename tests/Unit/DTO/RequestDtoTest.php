<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use Autodoctor\ModuleSocket\Connectors\Connector;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Enums\Commands;
use Autodoctor\ModuleSocket\Exceptions\ConfiguratorException;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\ValueObjects\Module;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LocalSocketServerInit;

#[CoversClass(RequestDto::class)]
class RequestDtoTest extends LocalSocketServerInit
{
    use RequestDataProvider;

    public static function requestDataProviderOfDto(): array
    {
        return array_merge(
            [
                [
                    'command' => 'relay_on',
                    'queryString' => '{"command":{"data":{"relay":{"relayNumber":1}}},"module":{"ip":"localhost","port":9761,"type":"Socket-3"}}',
                ],
                [
                    'command' => 'relay_off',
                    'queryString' => '{"command":{"data":{"relay":{"relayNumber":1}}},"module":{"ip":"localhost","port":9761,"type":"Socket-3"}}',
                ],
            ],
            self::requestDataProvider(),
        );
    }

    public function testConstruct(): void
    {
        $requestDto = new RequestDto(
            command: new Command(new CommandID(Commands::CheckConnect->value)),
            connector: new class () implements Connector {
                public function getConnector()
                {
                }
            },
            module: new Module(),
        );

        $this->assertInstanceOf(RequestDto::class, $requestDto);
    }

    /**
     * @throws InvalidInputParameterException
     * @throws ConfiguratorException
     * @throws InvalidRequestCommandException
     */
    #[DataProvider('requestDataProviderOfDto')]
    public function testFromRequest(string $command, ?string $queryString): void
    {
        $request = new Request($command, $queryString);

        $this->assertInstanceOf(RequestDto::class, RequestDto::fromRequest($request));
    }
}
