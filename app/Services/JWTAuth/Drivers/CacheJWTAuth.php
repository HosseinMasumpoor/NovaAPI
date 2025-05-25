<?php

namespace App\Services\JWTAuth\Drivers;

use App\Core\Facades\CacheFacade;
use App\Interfaces\JWTAuthInterface;

class CacheJWTAuth implements JWTAuthInterface
{
    const string CACHE_PREFIX = 'JWTAuth_';

    public function logout(string $token, $exp): bool
    {
        return CacheFacade::put(self::CACHE_PREFIX . $token, true, $exp);
    }

    public function authenticate(string $token): bool
    {
        return !CacheFacade::has(self::CACHE_PREFIX . $token);
    }
}
