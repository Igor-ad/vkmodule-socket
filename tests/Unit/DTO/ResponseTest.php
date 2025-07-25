<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use Autodoctor\ModuleSocket\DTO\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Response::class)]
class ResponseTest extends TestCase
{
    public static function responseDataProvider(): array
    {
        return [
            ['01'],
            ['02'],
            ['03023456'],
            ['040089'],
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
    public function testConstruct(string $responseData): void
    {
        $response = new Response($responseData);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->success);
    }

    #[DataProvider('responseDataProvider')]
    public function testGetEventId(string $responseData): void
    {
        $eventId = substr($responseData, 0, 2);

        $this->assertSame($eventId, Response::getDto($responseData)->getEventId());
    }

    #[DataProvider('responseDataProvider')]
    public function testGetEventDataItem(string $responseData): void
    {
        $expected = substr($responseData, 2, 2);
        $expectedData0 = $expected ?: null;
        $actualData0 = Response::getDto($responseData)->getEventDataItem(0);

        $this->assertEquals($expectedData0, $actualData0);
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

    #[DataProvider('responseDataProvider')]
    public function testToArray(string $responseData): void
    {
        $this->assertTrue(is_array(Response::getDto($responseData)->toArray()));
    }

    #[DataProvider('responseDataProvider')]
    public function testToJson(string $responseData): void
    {
        $this->assertTrue(is_array(json_decode(Response::getDto($responseData)->toJson(), true)));
    }
}
