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

        $container->add('service-class', ServiceClass::class);

        $this->assertInstanceOf(ServiceClass::class, $container->get('service-class'));
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

        $container->add('service-class', ServiceClass::class);

        $this->assertTrue($container->has('service-class'));

        $this->assertFalse($container->has('no-class'));
    }

    public function test_recursively_autowired()
    {
        $container = new Container();

        $container->add('service-class', ServiceClass::class);

        /** @var ServiceClass $service */
        $service = $container->get('service-class');

        $socialNetworks = $service->getSocialNetwork();

        $this->assertInstanceOf(SocialNetwork::class, $service->getSocialNetwork());
        $this->assertInstanceOf(Telegram::class, $socialNetworks->getTelegram());
        $this->assertInstanceOf(YouTube::class, $socialNetworks->getYouTube());
    }
}