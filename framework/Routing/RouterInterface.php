<?php

namespace SimplePhpFramework\Routing;

use SimplePhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}