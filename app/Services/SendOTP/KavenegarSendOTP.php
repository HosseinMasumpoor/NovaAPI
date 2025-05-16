<?php

namespace App\Services\SendOTP;

use App\Interfaces\SendOTPInterface;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;

class KavenegarSendOTP implements SendOTPInterface
{
    const string TOKEN = "584A68615A412F49795437754E67344A6B74435A50686F70374D2F56397A686E6A704E69673653427537343D";

    public function send(string $mobile, string $code)
    {
         try {

             $api = new \Kavenegar\KavenegarApi(self::TOKEN);
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
