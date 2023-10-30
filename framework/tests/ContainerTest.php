<?php

namespace SimplePhpFramework\Tests;

use PHPUnit\Framework\TestCase;
use SimplePhpFramework\Container\Container;
use SimplePhpFramework\Container\Exceptions\ContainerException;

class ContainerTest extends TestCase
{
    public function test_getting_service_from_container()
    {
        $container = new Container();

        $container->add('some-class', SomeClass::class);

        $this->assertInstanceOf(SomeClass::class, $container->get('some-class'));
    }

    public function test_container_has_exception_ContainerException_id_add_wrong_service()
    {
        $container = new Container();

        $this->expectException(ContainerException::class);

        $container->add('no-class');
    }

    public function test_has_method()
    {
        $container = new Container();

        $container->add('some-class', SomeClass::class);

        $this->assertTrue($container->has('some-class'));

        $this->assertFalse($container->has('no-class'));
    }
}