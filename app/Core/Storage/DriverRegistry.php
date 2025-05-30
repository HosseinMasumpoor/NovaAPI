<?php

namespace App\Core\Storage;

use App\Core\Exceptions\AuthException;
use App\Core\Exceptions\StorageException;

class DriverRegistry
{
    protected array $drivers = [];

    public function extend(string $driverName, callable $callback): void
    {
        $this->drivers[$driverName] = $callback;
    }

    public function resolve(string $driverName, array $config)
    {
        if(!isset($this->drivers[$driverName])) {
            throw new StorageException("Driver [$driverName] not registered");
        }
        return call_user_func($this->drivers[$driverName], $config);
    }
}
