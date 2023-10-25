<?php

namespace SimplePhpFramework\Http;

class Response
{
    public function __construct(
        private mixed $content,
        private int $statusCode = 200,
        private array $headers = [],
    ) {
    }

    public function send(): void
    {
        echo $this->content;
    }
}