<?php

namespace App\Core\Cache\Drivers;

use App\Core\Cache\Drivers\CacheDriverInterface;
use Predis\Client;

class RedisDriver implements CacheDriverInterface
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme' => $_ENV['REDIS_SCHEME'] ?? 'tcp',
            'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
            'port' => $_ENV['REDIS_PORT'] ?? 6379,
            'password' => $_ENV['REDIS_PASSWORD'] ?? null,
        ]);
    }

    public function put(string $key, string $value, int $ttl): bool
    {
        return (bool) $this->redis->setex($key, $ttl, $value);
    }

    public function get(string $key)
    {
        return $this->redis->get($key);
    }

    public function forget(string $key): bool
    {
        return (bool) $this->redis->del([$key]);
    }

    public function has(string $key): bool
    {
        return (bool) $this->redis->exists($key);
    }
}
