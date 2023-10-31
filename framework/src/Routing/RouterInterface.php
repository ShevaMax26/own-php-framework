<?php

namespace SimplePhpFramework\Routing;

use League\Container\Container;
use SimplePhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container);

    public function registerRoutes(array $routes): void;
}