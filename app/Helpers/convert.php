<?php

if (!function_exists('convertToValidMobileNumber')) {
    function convertToValidMobileNumber($mobileNumber): string
    {
        return "+98" . substr($mobileNumber, -10, 10);
    }
}
