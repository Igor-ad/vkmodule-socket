<?php

declare(strict_types=1);

namespace Tests\Unit\Validation;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Validator::class)]
class ValidatorTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator(ConfigurationProvider::fromConfigFile(Files::ConfigFile->getPath()));
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateAntiBounce(): void
    {
        $expected = 5;

        $this->assertSame($expected, $this->validator->validateAntiBounce(5));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateAntiBounce(524);
    }

    /**
     * Covers all arms of {@see Validator::validateEventId()}: set-input response IDs (20 / 30),
     * matching command/response IDs, unknown (0f) → exception, else false.
     *
     * @return array<string, array{0: string, 1: string}>
     */
    public static function validateEventIdAcceptsDataProvider(): array
    {
        return [
            'matching_ids' => ['22', '22'],
            'get_input_socket2_response_event_set_input_wire_id' => ['21', '20'],
            'get_input_socket1_response_event_set_input_wire_id' => ['31', '30'],
            'response_event_set_input_wire_id_bypasses_command_id' => ['01', '20'],
        ];
    }

    /**
     * @throws UnknownCommandException
     */
    #[DataProvider('validateEventIdAcceptsDataProvider')]
    public function testValidateEventIdAccepts(string $commandId, string $responseEventId): void
    {
        $this->assertTrue($this->validator->validateEventId($commandId, $responseEventId));
    }

    /**
     * @throws UnknownCommandException
     */
    public function testValidateEventIdThrowsWhenResponseIsUnknownCommand(): void
    {
        $this->expectException(UnknownCommandException::class);
        $this->validator->validateEventId('01', '0f');
    }

    /**
     * @throws UnknownCommandException
     */
    public function testValidateEventIdReturnsFalseWhenResponseDoesNotMatchAndIsNotSpecial(): void
    {
        $this->assertFalse($this->validator->validateEventId('01', '22'));
    }

    /**
     * When {@see Command::$commandData} is null, {@see Validator::validateResponse()} delegates only to
     * {@see Validator::validateEventId()} — e.g. GetInput (21) with firmware answering using SetInput wire id (20).
     *
     * @throws UnknownCommandException
     * @throws InvalidInputParameterException
     */
    public function testValidateResponseWithNullCommandDataAcceptsGetInputVersusSetInputEventId(): void
    {
        $command = new Command(new CommandID('21'));
        $response = new Response('2000');

        $this->assertTrue($this->validator->validateResponse($command, $response));
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateHost(): void
    {
        $expected = '192.168.0.191';

        $this->assertSame($expected, $this->validator->validateHost($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateHost('');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateInput(): void
    {
        $expected = 1;

        $this->assertSame($expected, $this->validator->validateInput($expected, 'Socket-2'));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateInput(48, 'Socket-Giant');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateInputAction(): void
    {
        $expected = 1;

        $this->assertSame($expected, $this->validator->validateInputAction($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateInputAction(10);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateInterval(): void
    {
        $expected = 10;

        $this->assertSame($expected, $this->validator->validateInterval($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateInterval(365);
    }

    /**
     * @throws InvalidRequestCommandException
     */
    public function testValidateModuleCommandId(): void
    {
        $expected = '44';

        $this->assertTrue($this->validator->validateModuleCommandId($expected, 'Socket-3'));

        $this->expectException(InvalidRequestCommandException::class);
        $this->validator->validateModuleCommandId('22', 'Socket-3');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidatePort(): void
    {
        $expected = 9761;

        $this->assertSame($expected, $this->validator->validatePort($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validatePort(21);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateRelay(): void
    {
        $expected = 1;

        $this->assertSame($expected, $this->validator->validateRelay($expected, 'Socket-3'));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateRelay(18, 'Socket-Giant');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateRelayAction(): void
    {
        $expected = 0;

        $this->assertSame($expected, $this->validator->validateRelayAction($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateRelayAction(5);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateRelayGroupControlData(): void
    {
        $expected = 'ffff';

        $this->assertSame($expected, $this->validator->validateRelayGroupControlData($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateRelayGroupControlData('acffff');
    }

    /**
     * @throws UnknownCommandException
     * @throws InvalidInputParameterException
     */
    public function testValidateResponse(): void
    {
        $expected = '21';
        $command = new Command(new CommandID($expected), new InputStatus(0));
        $response = new Response($expected . '00');

        $this->assertTrue($this->validator->validateResponse($command, $response));

        $expected = '22';
        $command = new Command(new CommandID($expected), Relay::fromArray([
            'relayNumber' => 0,
            'action' => 1,
            'interval' => 5,
        ]));
        $response = new Response($expected . '000105');

        $this->assertTrue($this->validator->validateResponse($command, $response));

        $expected = '01';
        $command = new Command(new CommandID($expected));
        $response = new Response($expected);

        $this->assertTrue($this->validator->validateResponse($command, $response));

        $unknownResponse = new Response('0f');

        $this->expectException(UnknownCommandException::class);
        $this->validator->validateResponse($command, $unknownResponse);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateTemperature(): void
    {
        $expected = 24;

        $this->assertSame($expected, $this->validator->validateTemperature(data: $expected, sign: 0));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateTemperature(data: 56, sign: 1);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateType(): void
    {
        $expected = 'Socket-1';

        $this->assertSame($expected, $this->validator->validateType($expected));

        $this->expectException(InvalidInputParameterException::class);
        $this->validator->validateType('');
    }

    public function testValidatorInstancesAreIndependent(): void
    {
        $first = new Validator(ConfigurationProvider::fromConfigFile(Files::ConfigFile->getPath()));
        $second = new Validator(ConfigurationProvider::fromConfigFile(Files::ConfigFile->getPath()));

        $this->assertNotSame($first, $second);
    }

}
