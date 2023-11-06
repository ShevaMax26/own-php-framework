<?php

namespace SimplePhpFramework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ConnectionFactory
{
    public function __construct(
        private readonly array $connectionParams
    )
    {
    }

    public function create(): Connection
    {
        return DriverManager::getConnection($this->connectionParams);
    }
}