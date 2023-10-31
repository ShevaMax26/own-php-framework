<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

use SimplePhpFramework\Http\Kernel;
use SimplePhpFramework\Http\Request;
use SimplePhpFramework\Routing\Router;

$request = Request::createFromGlobals();

$container = require BASE_PATH . '/config/services.php';

$router = new Router();
$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();



