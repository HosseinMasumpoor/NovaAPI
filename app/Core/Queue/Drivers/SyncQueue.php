<?php

namespace App\Core\Queue\Drivers;

use App\Core\Queue\Interfaces\JobInterface;
use App\Core\Queue\Interfaces\QueueInterface;

class SyncQueue implements QueueInterface
{

    public function push(JobInterface $job): void
    {
        $job->handle();
    }

    public function pop(): true
    {
        return true;
    }
}
