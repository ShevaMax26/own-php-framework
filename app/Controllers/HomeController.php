<?php

namespace App\Controllers;

use App\Services\YouTubeService;
use SimplePhpFramework\Http\Response;

class HomeController
{
    public function __construct(
        private readonly YouTubeService $youTube
    ) {
    }

    public function index(): Response
    {
        $content = '<h1>Hello, World!</h1><br>';
        $content .= "<a href=\"{$this->youTube->getChannelUrl()}\">YouTube</a>";

        return new Response($content);
    }
}