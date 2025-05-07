<?php

namespace App\Core\Cache\Drivers;

use App\Core\Cache\Drivers\CacheDriverInterface;

class RedisDriver implements CacheDriverInterface
{

    public function put(string $key, string $value, int $ttl)
    {
        // TODO: Implement put() method.
    }

    public function get(string $key)
    {
        // TODO: Implement get() method.
    }

    public function forget(string $key)
    {
        // TODO: Implement forget() method.
    }

    public function has(string $key)
    {
        // TODO: Implement has() method.
    }
}
