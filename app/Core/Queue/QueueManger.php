<?php

namespace App\Core\Queue;

use App\Core\Queue\Drivers\DatabaseQueue;
use App\Core\Queue\Drivers\FileQueue;
use App\Core\Queue\Drivers\CacheQueue;
use App\Core\Queue\Drivers\SyncQueue;
use App\Core\Queue\Interfaces\JobInterface;
use App\Core\Queue\Interfaces\QueueInterface;
use http\Exception\InvalidArgumentException;

class QueueManger
{
    private QueueInterface $driver;

    public function __construct()
    {
        $defaultDriverName = config('queue.driver');
        $this->driver = match ($defaultDriverName) {
            'cache' => new CacheQueue(),
            'file' => new FileQueue(),
            'database' => new DatabaseQueue(),
            'sync' => new SyncQueue(),
            default => throw new InvalidArgumentException("Unknown queue driver: $defaultDriverName"),
        };
    }

    public function push(JobInterface $job): void
    {
        $this->driver->push($job);
    }

    public function pop() : ?JobInterface
    {
        $data = $this->driver->pop();
        return $data ?? null;
    }
}
