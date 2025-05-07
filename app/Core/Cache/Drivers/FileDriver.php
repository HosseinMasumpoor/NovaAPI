<?php

namespace App\Core\Cache\Drivers;

use App\Core\Cache\Drivers\CacheDriverInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class FileDriver implements CacheDriverInterface
{
    protected FilesystemAdapter $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    public function put(string $key, string $value, int $ttl): bool
    {
        $cacheItem = $this->cache->getItem($key);
        $cacheItem->set($value);
        $cacheItem->expiresAfter($ttl);
        return $this->cache->save($cacheItem);
    }

    public function get(string $key)
    {
        $cacheItem = $this->cache->getItem($key);
        return $cacheItem->isHit() ? $cacheItem->get() : null;
    }

    public function forget(string $key): bool
    {
        return $this->cache->deleteItem($key);
    }

    public function has(string $key): bool
    {
        return $this->cache->hasItem($key);
    }
}
