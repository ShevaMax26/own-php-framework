<?php

namespace SimplePhpFramework\Console;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}