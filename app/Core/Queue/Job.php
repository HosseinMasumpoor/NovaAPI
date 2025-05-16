<?php

namespace App\Core\Queue;

use App\Core\Queue\Interfaces\JobInterface;

abstract class Job implements JobInterface
{

    abstract  public function handle();

    public function dispatch()
    {
        $queueManager = new QueueManger();

        $queueManager->push($this);
    }
}
