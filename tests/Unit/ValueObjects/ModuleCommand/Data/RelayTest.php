<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Relay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Relay::class)]
class RelayTest extends TestCase
{
    protected Relay $relay;

    protected function setUp(): void
    {
        parent::setUp();
        $this->relay = Relay::fromArray(['relayNumber' => 0, 'action' => 1, 'interval' => 10]);
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Relay::class, $this->relay);
    }

    public function testIsEqual(): void
    {
        $anotherRelay = Relay::fromArray(['relayNumber' => 0, 'action' => 1, 'interval' => 10]);

        $this->assertTrue($this->relay->isEqual($anotherRelay));
    }

    public function testValidatorRejectsInvalidRelayAction(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));

        $this->expectException(InvalidInputParameterException::class);
        $validator->validateRelayAction(10);
    }

    public function testValidatorRejectsInvalidInterval(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));

        $this->expectException(InvalidInputParameterException::class);
        $validator->validateInterval(512);
    }

    public function testToArray(): void
    {
        $expected = [
            CommandDataRootKey::Relay->value => [
                'relayNumber' => 0,
                'action' => 1,
                'interval' => 10,
            ]
        ];

        $this->assertSame($expected, $this->relay->toArray());
    }

    public function testToStream(): void
    {
        $expected = chr(0) . chr(1) . chr(10);

        $this->assertSame($expected, $this->relay->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(0) . hexFormat(1) . hexFormat(10);

        $this->assertSame($expected, $this->relay->toString());
    }
}
