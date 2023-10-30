<?php

namespace SimplePhpFramework\Container;

use Psr\Container\ContainerInterface;
use SimplePhpFramework\Container\Exceptions\ContainerException;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object $concrete = null)
    {
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id not found");
            }

            $concrete = $id;
        }

        $this->services[$id] = $concrete;
    }

    public function get(string $id)
    {
        if (! $this->has($id)) {
            if (! class_exists($id)) {
                throw new ContainerException("Service $id could not be resolved");
            }

            $this->add($id);
        }

        $instance = $this->resolve($this->services[$id]);

        return $instance;
    }

    private function resolve($class)
    {
        // 1. Створити екзепляр класу Reflection

        $reflectionClass = new \ReflectionClass($class);

        // 2. Використовувати Reflection, щоб отримати конструктор класу

        $constructor = $reflectionClass->getConstructor();

        // 3. Якщо немає конструктора, то прокто створюємо екземпляр класу

        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }

        // 4. Отримати параметри конструктора

        $constructorParams = $constructor->getParameters();

        // 5. Отримати залежності

        $classDependencies = $this->resolveClassDependencies($constructorParams);

        // 6. Створити обє'кт з залежностями

        $instance = $reflectionClass->newInstanceArgs($classDependencies);

        // 7. Вернути об'єкт

        return $instance;
    }

    private function resolveClassDependencies(array $constructorParams): array
    {
        // 1. Ініціалізувати пустий список залежностей

        $classDependencies = [];

        // 2. Спробувати знайти і створити екземпляр

        /** @var \ReflectionParameter $constructorParam */
        foreach ($constructorParams as $constructorParam) {

            // Отримати тип параметра

            $serviceType = $constructorParam->getType();

            // Спробувати знайти екземпляр використовуючи $serviceType

            $service = $this->get($serviceType->getName());

            // Додати сервіс в $classDependencies

            $classDependencies[] = $service;
        }

        // 3. Вернути масив $classDependencies

        return $classDependencies;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}