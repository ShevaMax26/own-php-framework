<?php

namespace App\Controllers;

use App\Services\YouTubeService;
use SimplePhpFramework\Http\Response;
use Twig\Environment;

class HomeController
{
    public function __construct(
        private readonly YouTubeService $youTube,
        private readonly Environment $twig
    ) {
    }

    public function index(): Response
    {
        dd($this->twig);
        $content = '<h1>Hello, World!</h1><br>';
        $content .= "<a href=\"{$this->youTube->getChannelUrl()}\">YouTube</a>";

        return new Response($content);
    }
}