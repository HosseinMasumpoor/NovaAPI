<?php

namespace App\Core\Queue\Interfaces;

interface QueueInterface
{
    public function push(JobInterface $job);
    public function pop();
}
