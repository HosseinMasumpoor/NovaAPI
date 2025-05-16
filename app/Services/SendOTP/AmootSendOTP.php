<?php

namespace App\Services\SendOTP;

use App\Interfaces\SendOTPInterface;

class AmootSendOTP implements SendOTPInterface
{
    const string URL = "https://portal.amootsms.com/rest/SendQuickOTP";
    const string TOKEN = "0B4E1F424AC55B97C3141AD367EFBF35AAA35C6A";

    public function send(string $mobile, string $code): bool
    {
        $mobile = substr($mobile,  -10);
        $url = self::URL;

        $codeLength = strlen($code);

        $url = $url."?"."Token=".urlencode(self::TOKEN);
        $url = $url."&"."Mobile=$mobile";
        $url = $url."&"."CodeLength=$codeLength";
        $url = $url."&"."OptionalCode=$code";

        $json =  file_get_contents($url);
        $result = json_decode($json);
        return $result->Status;
    }
}
