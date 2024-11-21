<?php declare(strict_types=1);

namespace Resources;

use Autodoctor\ModuleSocket\Resources\AbstractResource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractResource::class)]
class AbstractResourceTest extends TestCase
{
    public function testToJson() {}

    public function testMake() {}

    public function testToArray() {}
}
