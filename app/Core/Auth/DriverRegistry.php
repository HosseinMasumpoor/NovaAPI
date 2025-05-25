<?php

namespace App\Core\Auth;

use App\Core\Exceptions\AuthException;

class DriverRegistry
{
    protected array $drivers = [];

    public function extend(string $name, callable $callback): void
    {
        $this->drivers[$name] = $callback;
    }

    public function getDriverFactory(string $name)
    {
        if(!isset($this->drivers[$name])) {
            throw new AuthException("Driver [$name] not registered");
        }
        return $this->drivers[$name];
    }
}
