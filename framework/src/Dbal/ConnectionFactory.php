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
        $connection = DriverManager::getConnection($this->connectionParams);

        $connection->setAutoCommit(false);

        return $connection;
    }
}