<?php declare(strict_types=1);

namespace DTO;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Exceptions\ModuleException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(Response::class)]
class ResponseTest extends TestCase
{
    public static function responseDataProvider(): array
    {
        return [
            ['01'],
            ['02'],
            ['03'],
            ['04'],
            ['20000105'],
            ['2100'],
            ['22000130'],
            ['23'],
            ['24'],
            ['250000'],
            ['30000105'],
            ['3100'],
            ['32'],
            ['41'],
            ['42'],
            ['43000150'],
            ['44'],
        ];
    }

    #[DataProvider('responseDataProvider')]
    public function test__construct(string $responseData): void
    {
        $response = new Response($responseData);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->success);
    }

    #[DataProvider('responseDataProvider')]
    public function testGetItem(string $responseData): void
    {
        $data0 = Response::getDto($responseData)->getItem(0);
        $this->assertTrue($data0 === '00' || is_null($data0));
    }

    #[DataProvider('responseDataProvider')]
    public function testGetDto(string $responseData): void
    {
        $this->assertInstanceOf(Response::class, Response::getDto($responseData));
    }

    #[DataProvider('responseDataProvider')]
    public function testDataToHexString(string $responseData): void
    {
        $this->assertSame(substr($responseData, 2), Response::getDto($responseData)->dataToHexString());
    }

    /**
     * @throws ModuleException
     */
    #[DataProvider('responseDataProvider')]
    public function testToArray(string $responseData): void
    {
        $this->assertTrue(is_array(Response::getDto($responseData)->toArray()));
    }

    /**
     * @throws ModuleException
     */
    #[DataProvider('responseDataProvider')]
    public function testToJson(string $responseData): void
    {
        $this->assertTrue(is_array(json_decode(Response::getDto($responseData)->toJson(), true)));
    }

    #[CoversNothing]
    public function testResponseClassIsFinal(): void
    {
        $reflectionClass = new ReflectionClass(Response::class);
        $this->assertTrue($reflectionClass->isFinal());
    }
}
