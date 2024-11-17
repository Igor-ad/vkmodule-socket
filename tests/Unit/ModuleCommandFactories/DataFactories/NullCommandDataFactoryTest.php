<?php

declare(strict_types=1);

namespace ModuleCommandFactories\DataFactories;

use Autodoctor\ModuleSocket\ModuleCommandFactories\DataFactories\NullCommandDataFactory;
use PHPUnit\Framework\TestCase;

class NullCommandDataFactoryTest extends TestCase
{
    public function testMake(): void
    {
        $factory = new NullCommandDataFactory();
        $data = $factory->make();
        $this->assertTrue(is_null($data));
    }
}
