<?php

namespace SimplePhpFramework\Console;

use Psr\Container\ContainerInterface;

class Kernel
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly Application $application
    )
    {
    }

    public function handle(): int
    {
        // 1. Реєстрація команд за допомогою контейнера
        $this->registerCommands();

        // 2. Запуск команди
        $status = $this->application->run();

        dd($status);

        // 3. Вератємо статус
    }

    private function registerCommands(): void
    {
        // Реєстрація системних команд

        // 1. Отримати всі файли з папки Commands
        $commandFiles = new \DirectoryIterator(__DIR__.'/Commands');
        $namespace = $this->container->get('framework-commands-namespace');

        // 2. Пройтись по всім файлам
        foreach ($commandFiles as $commandFile) {
            if (! $commandFile->isFile()) {
                continue;
            }

            // 3. Отримати ім'я класу команди
            $command = $namespace . pathinfo($commandFile, PATHINFO_FILENAME);

            // 4. Якщо це підклас CommandIntarface
            if (is_subclass_of($command, CommandInterface::class)) {

                // -> Додати в контейнер (використовуючи ім'я команди в якості ID)
                $name = (new \ReflectionClass($command))
                    ->getProperty('name')
                    ->getDefaultValue();

                $this->container->add("console:$name", $command);
            }
        }

        // Реєстраця клієнтських команд
    }
}