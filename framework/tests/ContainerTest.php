<?php

namespace SimplePhpFramework\Tests;

use PHPUnit\Framework\TestCase;
use SimplePhpFramework\Container\Container;

class ContainerTest extends TestCase
{
    public function test_getting_service_from_container()
    {
        $container = new Container();

        $container->add('some-class', SomeClass::class);

        $this->assertInstanceOf(SomeClass::class, $container->get('some-class'));
    }
}