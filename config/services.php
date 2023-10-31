<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use SimplePhpFramework\Http\Kernel;
use SimplePhpFramework\Routing\Router;
use SimplePhpFramework\Routing\RouterInterface;

// Application params
$routes = include BASE_PATH . '/routes/web.php';

// Application services

$container = new Container();

$container->delegate(new ReflectionContainer(true));

$container->add('APP_ENV', new StringArgument('production'));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

return $container;