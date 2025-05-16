<?php

namespace App\Jobs;

use App\Core\Queue\Job;
use App\Interfaces\SendOTPInterface;

class SendSMSNotificationJob extends Job
{
    public function __construct(private string $mobile, private string $code){}

    public function handle(): void
    {
        app()->make(SendOTPInterface::class)->send($this->mobile, $this->code);
    }
}
