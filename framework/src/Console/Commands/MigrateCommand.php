<?php

namespace SimplePhpFramework\Console\Commands;

use SimplePhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';
    public function execute(array $parameters = []): int
    {
        dump($parameters, $this->name);

        return 0;
    }
}