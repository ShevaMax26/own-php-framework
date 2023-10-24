<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MaxymShevchuk\Framework\Http\Kernel;
use MaxymShevchuk\Framework\Http\Request;
use MaxymShevchuk\Framework\Http\Response;

$request = Request::createFromGlobals();

$kernel = new Kernel();
$response = $kernel->handle($request);

$response->send();



