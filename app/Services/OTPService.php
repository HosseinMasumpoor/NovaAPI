<?php

namespace App\Services;


use App\Core\Facades\CacheFacade;
use App\Core\Facades\LogFacade;
use App\Exceptions\AuthException;

class OTPService
{
    const CACHE_KEY_PREFIX = 'user_mobile_';
    const OTP_EXPIRES_IN = 60;
    public  function send($mobile): array
    {
        if($this->checkIsSent($mobile)){
            throw AuthException::otpAlreadySent();
        }

        $code = random_int(100000, 999999);
        CacheFacade::put(self::CACHE_KEY_PREFIX.$mobile, $code, self::OTP_EXPIRES_IN);
        //TODO: Send otp code by SMS
        LogFacade::info("Sending OTP to mobile number $mobile : $code");

        return [
            'expires_in' => self::OTP_EXPIRES_IN,
        ];
    }

    public function verify(string $mobile, string $otp): bool
    {
        $cacheKey = self::CACHE_KEY_PREFIX.$mobile;
        if(CacheFacade::get($cacheKey) == $otp){
            CacheFacade::forget($cacheKey);
            return true;
        }
        return false;
    }

    private function checkIsSent($mobile)
    {
        return CacheFacade::has(self::CACHE_KEY_PREFIX.$mobile);
    }
}
