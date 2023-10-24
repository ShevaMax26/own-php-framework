<?php

namespace MaxymShevchuk\Framework\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        //controller->content
        $content = 'Hello World!';

        return new Response($content);
    }
}