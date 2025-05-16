<?php

namespace App\Core\Cache;

use App\Core\Cache\Drivers\CacheDriverInterface;

class Cache
{
    protected CacheDriverInterface $driver;
    public function __construct(){

        $driverName = config('cache.driver') ?? 'file';
        $this->driver = DriverResolver::resolve($driverName);
    }

    public function put($key, $value, $ttl = 3600){
        return $this->driver->put($key, $value, $ttl);
    }

    public function get($key, $default = null){
        return $this->driver->get($key) ?? $default;
    }

    public function forget($key){
        return $this->driver->forget($key);
    }

    public function has($key): void
    {
        $this->driver->has($key);
    }
}
