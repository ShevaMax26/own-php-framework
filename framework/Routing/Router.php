<?php

namespace SimplePhpFramework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use SimplePhpFramework\Http\Exceptions\MethodNotAllowedException;
use SimplePhpFramework\Http\Exceptions\RouteNotFoundException;
use SimplePhpFramework\Http\Request;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        [$controller, $method] = $handler;

        return [[new $controller, $method], $vars];
    }

    /**
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routerInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        switch ($routerInfo[0]) {
            case Dispatcher::FOUND:
                return [$routerInfo[1], $routerInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routerInfo[1]);
                throw new MethodNotAllowedException("Supported HTTP methods: {$allowedMethods}");
            default:
                throw new RouteNotFoundException('Route not found');
        }
    }
}