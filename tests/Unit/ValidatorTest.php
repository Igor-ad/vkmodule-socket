<?php

declare(strict_types=1);

namespace Tests\Unit;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Exceptions\InvalidRequestCommandException;
use Autodoctor\ModuleSocket\Exceptions\UnknownCommandException;
use Autodoctor\ModuleSocket\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Command;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\CommandID;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\InputStatus;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionException;

#[CoversClass(Validator::class)]
class ValidatorTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $object = Validator::instance();
        $method = new ReflectionMethod($object, '__construct');

        $this->assertTrue($method->isPrivate());

        $method->invoke($object);
    }

    public function testInstance(): void
    {
        $instance = Validator::instance();

        $this->assertInstanceOf(Validator::class, $instance);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateAntiBounce(): void
    {
        $expected = 5;

        $this->assertSame($expected, Validator::instance()->validateAntiBounce(5));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateAntiBounce(524);
    }

    /**
     * @throws UnknownCommandException
     * @throws InvalidInputParameterException
     */
    public function testValidateEventId(): void
    {
        $this->testValidateResponse();
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateHost(): void
    {
        $expected = '192.168.0.191';

        $this->assertSame($expected, Validator::instance()->validateHost($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateHost('');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateInput(): void
    {
        $expected = 1;

        $this->assertSame($expected, Validator::instance()->validateInput($expected, 'Socket-2'));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateInput(48, 'Socket-Giant');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateInputAction(): void
    {
        $expected = 1;

        $this->assertSame($expected, Validator::instance()->validateInputAction($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateInputAction(10);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateInterval(): void
    {
        $expected = 10;

        $this->assertSame($expected, Validator::instance()->validateInterval($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateInterval(365);
    }

    /**
     * @throws InvalidRequestCommandException
     */
    public function testValidateModuleCommandId(): void
    {
        $expected = '44';

        $this->assertTrue(Validator::instance()->validateModuleCommandId($expected, 'Socket-3'));

        $this->expectException(InvalidRequestCommandException::class);
        Validator::instance()->validateModuleCommandId('22', 'Socket-3');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidatePort(): void
    {
        $expected = 9761;

        $this->assertSame($expected, Validator::instance()->validatePort($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validatePort(21);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateRelay(): void
    {
        $expected = 1;

        $this->assertSame($expected, Validator::instance()->validateRelay($expected, 'Socket-3'));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateRelay(18, 'Socket-Giant');
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateRelayAction(): void
    {
        $expected = 0;

        $this->assertSame($expected, Validator::instance()->validateRelayAction($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateRelayAction(5);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateRelayGroupControlData(): void
    {
        $expected = 'ffff';

        $this->assertSame($expected, Validator::instance()->validateRelayGroupControlData($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateRelayGroupControlData('acffff');
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

        $this->assertTrue(Validator::instance()->validateResponse($command, $response));

        $expected = '22';
        $command = new Command(new CommandID($expected), new Relay(0, 1, 5));
        $response = new Response($expected . '000105');

        $this->assertTrue(Validator::instance()->validateResponse($command, $response));

        $expected = '01';
        $command = new Command(new CommandID($expected));
        $response = new Response($expected);

        $this->assertTrue(Validator::instance()->validateResponse($command, $response));

        $unknownResponse = new Response('0f');

        $this->expectException(UnknownCommandException::class);
        Validator::instance()->validateResponse($command, $unknownResponse);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateTemperature(): void
    {
        $expected = 24;

        $this->assertSame($expected, Validator::instance()->validateTemperature(data: $expected, sign: 0));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateTemperature(data: 56, sign: 1);
    }

    /**
     * @throws InvalidInputParameterException
     */
    public function testValidateType(): void
    {
        $expected = 'Socket-1';

        $this->assertSame($expected, Validator::instance()->validateType($expected));

        $this->expectException(InvalidInputParameterException::class);
        Validator::instance()->validateType('');
    }

    public function testUniqueness(): void
    {
        $expected = Validator::class;
        $firstInstance = Validator::instance();

        $this->assertNotNull($firstInstance);
        $this->assertInstanceOf($expected, $firstInstance);

        $secondInstance = Validator::instance();

        $this->assertNotNull($secondInstance);
        $this->assertInstanceOf($expected, $secondInstance);
        $this->assertEquals($firstInstance, $secondInstance);
    }
}
