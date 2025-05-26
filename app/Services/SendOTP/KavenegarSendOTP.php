<?php

namespace App\Services\SendOTP;

use App\Interfaces\SendOTPInterface;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;

class KavenegarSendOTP implements SendOTPInterface
{
    private string $token;
    public function __construct()
    {
        $this->token = config('kavenegar.api_token');
    }

    public function send(string $mobile, string $code)
    {
         try {

             $api = new \Kavenegar\KavenegarApi($this->token);
             $receptor = $mobile;
             $token = $code;
             $token2 = "";
             $token3 = "";
             $template = 'otp';
             $type = "sms"; //sms | call
             $api->VerifyLookup($receptor, $token, $token2, $token3, $template, $type);

             return true;
         } catch (ApiException $e) {
             return $e->errorMessage();
         } catch (HttpException $e) {
             return $e->errorMessage();
         }
    }
}
