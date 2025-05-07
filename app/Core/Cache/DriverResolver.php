<?php

namespace App\Core\Cache;

use App\Core\Cache\Drivers\CacheDriverInterface;
use App\Core\Cache\Drivers\FileDriver;
use App\Core\Cache\Drivers\RedisDriver;
use http\Exception\InvalidArgumentException;

class DriverResolver
{
    public static function resolve(string $driver): CacheDriverInterface
    {
        return match (strtolower($driver)){
            "redis" => new RedisDriver(),
            "file" => new FileDriver(),
            default => throw new InvalidArgumentException("Unsupported driver: $driver")
        };
    }
}
