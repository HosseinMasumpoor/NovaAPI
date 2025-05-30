<?php

namespace App\Core\Storage;

use App\Core\Storage\Interfaces\StorageDriverInterface;

class Storage
{
    private array $disks = [];

    public function __construct(private readonly DriverRegistry $registry)
    {
    }

    public function disk(string $name = null) : StorageDriverInterface
    {
        $name ??= config('storage.default');

        if(!isset($this->disks[$name])) {
            $diskConfig = config('storage.disks.' . $name);
            $this->disks[$name] = $this->registry->resolve($diskConfig["driver"], $diskConfig);
        }

        return $this->disks[$name];
    }

    public function __call(string $method, array $arguments)
    {
        return $this->disk()->$method(...$arguments);
    }
}
