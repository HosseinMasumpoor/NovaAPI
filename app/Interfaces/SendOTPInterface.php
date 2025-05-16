<?php

namespace App\Interfaces;

interface SendOTPInterface
{
    public function send(string $mobile, string $code);
}
