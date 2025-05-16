<?php

namespace App\Core\Queue\Drivers;

use App\Core\Queue\Interfaces\JobInterface;
use App\Core\Queue\Interfaces\QueueInterface;

class FileQueue implements QueueInterface
{
    private string $path;

    public function __construct()
    {
        $this->path = basePath("storage/core/queue");
        if(!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    public function push(JobInterface $job): void
    {
        $fileName = $this->path . "/" . uniqid('job_', true) . '.job';
        file_put_contents($fileName, serialize($job));
    }

    public function pop(): ?JobInterface
    {
        $jobs = glob($this->path . "/*.job");
        if(empty($jobs)) {
            return null;
        }

        $job = file_get_contents($jobs[0]);

        unlink($jobs[0]);

        if(is_string($job)) {
            return unserialize($job);
        }

        return null;
    }
}
