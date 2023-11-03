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
        return $this->render('home.html.twig', [
            'youTubeChannel' => $this->youTube->getChannelUrl(),
        ]);
    }
}