<?php

namespace App\Exceptions;


use Exception;

class JWTException extends Exception
{
    public static function otpAlreadySent() : self{
        return new self(trans('auth.otp.is_sent'), 429);
    }
}
