<?php

namespace SimplePhpFramework\Tests;

class SocialNetwork
{
    public function __construct(
        private readonly Telegram $telegram,
        private readonly YouTube $youTube
    )
    {
    }

    public function getTelegram(): Telegram
    {
        return $this->telegram;
    }

    public function getYouTube(): YouTube
    {
        return $this->youTube;
    }


}