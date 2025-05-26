<?php

namespace App\Services\SendOTP;

use App\Interfaces\SendOTPInterface;

class AmootSendOTP implements SendOTPInterface
{
    private string $url;
    private string $token;

    public function __construct()
    {
        $this->url = config('amoot.api_url');
        $this->token = config('amoot.api_token');
    }

    public function send(string $mobile, string $code): bool
    {
        $mobile = substr($mobile,  -10);
        $url = $this->url;

        $codeLength = strlen($code);

        $url = $url."?"."Token=".urlencode($this->token);
        $url = $url."&"."Mobile=$mobile";
        $url = $url."&"."CodeLength=$codeLength";
        $url = $url."&"."OptionalCode=$code";

        $json =  file_get_contents($url);
        $result = json_decode($json);
        return $result->Status;
    }
}
