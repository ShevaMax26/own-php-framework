<?php

namespace App\Controllers;

use App\Services\YouTubeService;
use SimplePhpFramework\Controller\AbstractController;
use SimplePhpFramework\Http\Response;
use Twig\Environment;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly YouTubeService $youTube,
    ) {
    }

    public function index(): Response
    {
        dd($this->container->get('twig'));
        $content = '<h1>Hello, World!</h1><br>';
        $content .= "<a href=\"{$this->youTube->getChannelUrl()}\">YouTube</a>";

        return new Response($content);
    }
}