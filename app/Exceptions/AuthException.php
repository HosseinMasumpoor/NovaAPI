<?php

namespace App\Exceptions;


use Exception;

class AuthException extends Exception
{
    public static function otpAlreadySent() : self{
        return new self(trans('auth.otp.is_sent'), 429);
    }
}
