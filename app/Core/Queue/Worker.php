<?php

namespace App\Core\Queue;

readonly class Worker
{
    public function __construct(private QueueManger $queueManger)
    {
        while (true){
            $job = $this->queueManger->pop();
            if($job){
                $job->handle();
            }else{
                sleep(1);
            }
        }
    }
}
