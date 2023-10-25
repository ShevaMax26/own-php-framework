<?php

namespace App\Controllers;

use SimplePhpFramework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = 'Hello, World!';

        return new Response($content);
    }
}