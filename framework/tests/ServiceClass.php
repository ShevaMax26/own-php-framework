<?php

namespace SimplePhpFramework\Tests;

class ServiceClass
{
    public function __construct(
        private readonly SocialNetwork $socialNetworks
    )
    {
    }

    public function getSocialNetwork(): SocialNetwork
    {
        return $this->socialNetworks;
    }
}