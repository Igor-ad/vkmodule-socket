<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Autodoctor\ModuleSocket\Console\BaseConsoleCommand;
use Autodoctor\ModuleSocket\Controllers\ControllerInterface;
use Autodoctor\ModuleSocket\DTO\Request;
use Autodoctor\ModuleSocket\DTO\RequestDto;
use Autodoctor\ModuleSocket\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\LocalSocketServerInit;

#[CoversClass(BaseConsoleCommand::class)]
class BaseConsoleCommandTest extends LocalSocketServerInit
{
    use ConsoleDataProvider;

    #[DataProvider('commandWithResultDataProvider')]
    public function testExecute(
        string $commandName,
        ?string $queryString,
        int|string $expectedResult,
    ): void {
        $serviceName = 'new_service';

        $mockCommand = new class ($serviceName) extends BaseConsoleCommand {
            public int|string $expectedResult;

            public function handle(string $commandName, ?string $queryString): int|string
            {
                return $this->expectedResult;
            }

            public function setExpectedResult(int|string $expectedResult): void
            {
                $this->expectedResult = $expectedResult;
            }
        };

        $mockCommand->setExpectedResult($expectedResult);
        $result = $mockCommand->execute($commandName, $queryString);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @throws Exception
     */
    public function testRunInvokesControllerWithCorrectData(): void
    {
        $expected = 'processed OK';
        $queryString = '{"command":{"data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},'
            . '"module":{"host":"127.0.0.1","port":9761,"type":"Socket-2"}}';
        $request = Request::fromInput(
            'input_setup',
            $queryString,
            $this->testConfiguration,
            new Validator($this->testConfiguration),
        );
        $requestDto = RequestDto::fromRequest($request);
        $commandData = $requestDto->command->commandData;
        $this->assertNotNull($commandData);

        $controller = $this->createMock(ControllerInterface::class);
        $controller->expects($this->once())
            ->method('inputSetup')
            ->with($commandData)
            ->willReturn($expected);

        $command = new class ('dummy_service') extends BaseConsoleCommand {
            public function publicRun(ControllerInterface $controller): string
            {
                return $this->run($controller);
            }

            public function handle(string $commandName, ?string $queryString): int|string
            {
                return 0;
            }

            public function setControllerMethod(string $method): void
            {
                $this->controllerMethod = $method;
            }

            public function setRequestDto(RequestDto $dto): void
            {
                $this->requestDto = $dto;
            }
        };

        $command->setControllerMethod('inputSetup');
        $command->setRequestDto($requestDto);

        $this->assertSame($expected, $command->publicRun($controller));
    }
}
