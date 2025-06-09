<?php

namespace App\Core\Validation;

use App\Core\Validation\Contracts\ValidatorDriverInterface;
use InvalidArgumentException;

class DriverRegistry
{
    protected array $drivers = [];

    public function extend(string $name, callable $callback): void
    {
        $this->drivers[$name] = $callback;
    }

    public function resolve(string $name, $config = []): ValidatorDriverInterface
    {
        if(!isset($this->drivers[$name])) {
            throw new InvalidArgumentException("Validator driver [$name] not registered.");
        }

        $driver = call_user_func($this->drivers[$name], $config);

        if (!$driver instanceof ValidatorDriverInterface) {
            throw new InvalidArgumentException("Validator driver [$name] must implement ValidatorDriverInterface.");
        }

        return $driver;
    }

    public function has(string $name): bool
    {
        return isset($this->drivers[$name]);
    }
}
