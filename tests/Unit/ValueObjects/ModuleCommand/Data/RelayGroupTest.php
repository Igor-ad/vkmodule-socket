<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\RelayGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelayGroup::class)]
class RelayGroupTest extends TestCase
{
    protected RelayGroup $relayGroup;

    protected function setUp(): void
    {
        parent::setUp();
        $this->relayGroup = RelayGroup::fromArray(['relayGroupAction' => '0000']);
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(RelayGroup::class, $this->relayGroup);
    }

    public function testValidatorRejectsInvalidGroupData(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));

        $this->expectException(InvalidInputParameterException::class);
        $validator->validateRelayGroupControlData('ffff1d');
    }

    public function testToArray(): void
    {
        $expected = [
            CommandDataRootKey::RelayGroup->value => [
                'relayGroupAction' => '0000',
            ]
        ];

        $this->assertSame($expected, $this->relayGroup->toArray());
    }

    public function testIsEqual(): void
    {
        $anotherRelayGroup = RelayGroup::fromArray(['relayGroupAction' => '0000']);

        $this->assertTrue($this->relayGroup->isEqual($anotherRelayGroup));
    }

    public function testToStream(): void
    {
        $expected = chr(hexdec('0000'));

        $this->assertSame($expected, $this->relayGroup->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(hexdec('0000'), 4);

        $this->assertSame($expected, $this->relayGroup->toString());
    }
}
