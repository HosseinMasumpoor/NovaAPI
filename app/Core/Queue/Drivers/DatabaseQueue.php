<?php

namespace App\Core\Queue\Drivers;

use App\Core\Queue\Interfaces\JobInterface;
use App\Core\Queue\Interfaces\QueueInterface;
use App\Core\Queue\Interfaces\QueueRepositoryInterface;

class DatabaseQueue implements QueueInterface
{
    private QueueRepositoryInterface $repository;
    public function __construct()
    {
        $this->repository = app()->make(QueueRepositoryInterface::class);
    }

    public function push(JobInterface $job): void
    {
        $serializedJob = serialize($job);
        $this->repository->store($serializedJob);
    }

    public function pop()
    {
        $job = $this->repository->getNext();
        if(!$job){
            return null;
        }

        $this->repository->delete($job['id']);

        return unserialize($job['job']);
    }
}
