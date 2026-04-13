<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\ModuleCommand\Data;

use Autodoctor\ModuleSocket\Configuration\ConfigurationProvider;
use Autodoctor\ModuleSocket\Enums\CommandDataRootKey;
use Autodoctor\ModuleSocket\Enums\Files;
use Autodoctor\ModuleSocket\Exceptions\InvalidInputParameterException;
use Autodoctor\ModuleSocket\Validation\Validator;
use Autodoctor\ModuleSocket\ValueObjects\ModuleCommand\Data\Input;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Input::class)]
class InputTest extends TestCase
{
    protected Input $input;

    protected function setUp(): void
    {
        parent::setUp();
        $this->input = Input::fromArray(['inputNumber' => 0, 'action' => 1, 'antiBounce' => 5]);
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Input::class, $this->input);
    }

    public function testValidatorRejectsInvalidInputAction(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));

        $this->expectException(InvalidInputParameterException::class);
        $validator->validateInputAction(10);
    }

    public function testValidatorRejectsInvalidAntiBounce(): void
    {
        $validator = new Validator(ConfigurationProvider::fromConfigFile(Files::TestConfigFile->getPath()));

        $this->expectException(InvalidInputParameterException::class);
        $validator->validateAntiBounce(512);
    }

    public function testIsEqual(): void
    {
        $anotherInput = Input::fromArray(['inputNumber' => 0, 'action' => 1, 'antiBounce' => 5]);

        $this->assertTrue($this->input->isEqual($anotherInput));
    }

    public function testToArray(): void
    {
        $expected = [
            CommandDataRootKey::Input->value => [
                'inputNumber' => 0,
                'action' => 1,
                'antiBounce' => 5,
            ]
        ];

        $this->assertSame($expected, $this->input->toArray());
    }

    public function testToStream(): void
    {
        $expected = chr(0) . chr(1) . chr(5);

        $this->assertSame($expected, $this->input->toStream());
    }

    public function testToString(): void
    {
        $expected = hexFormat(0) . hexFormat(1) . hexFormat(5);

        $this->assertSame($expected, $this->input->toString());
    }
}
