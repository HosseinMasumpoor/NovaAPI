<?php

namespace App\Services\JWTAuth;

use App\Interfaces\JWTAuthInterface;
use App\Services\JWTService;

readonly class JWTAuthService
{
    private int $tokenExpiration;
    public function __construct(private JWTService $jwtService, private JWTAuthInterface $jwtAuthDriver){
        $this->tokenExpiration = config('jwt-auth.token_expiration');
    }

    public function login(string $userId): string
    {
        return $this->jwtService->encode([
            'id' => $userId,
        ], $this->tokenExpiration);
    }

    public function logout(string $token): bool
    {
        $exp = time() + $this->tokenExpiration;

        if(!$this->jwtAuthDriver){ // Driver is set on null
            return true;
        }

        return $this->jwtAuthDriver->logout($token, $exp);
    }

    public function checkAuth(string $token): ?string
    {
        $result = $this->jwtService->decode($token);
        $data = $result->data ?? null;
        if($this->jwtAuthDriver){
            if($this->jwtAuthDriver->authenticate($token))
            {
                return $data?->id;
            }
            return null;
        }

        return $result->id;
    }

}
