<?php declare(strict_types=1);

namespace Resources;

use Autodoctor\ModuleSocket\DTO\Response;
use Autodoctor\ModuleSocket\Resources\BaseResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BaseResource::class)]
class BaseResourceTest extends TestCase
{
    public function testDataToArray(): void
    {
        $response = new Response('01');
        $expected = ['data' => null];
        $this->assertSame($expected, BaseResource::make()->dataToArray($response));
    }
}
