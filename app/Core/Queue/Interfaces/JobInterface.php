<?php

namespace App\Core\Queue\Interfaces;

interface JobInterface
{
    public function handle();
}
