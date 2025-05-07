<?php

namespace App\Core\Cache\Drivers;

interface CacheDriverInterface
{
    public function put(string $key, string $value, int $ttl);

    public function get(string $key);

    public function forget(string $key);

    public function has(string $key);
}
