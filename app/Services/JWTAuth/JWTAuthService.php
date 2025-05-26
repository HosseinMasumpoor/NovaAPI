<?php

namespace App\Services\JWTAuth;

use App\Interfaces\JWTAuthInterface;
use App\Services\JWTService;

readonly class JWTAuthService
{
    private int $tokenExpiration;
    private int $refreshExpiration;

    public function __construct(private JWTService $jwtService, private JWTAuthInterface $jwtAuthDriver){
        $this->tokenExpiration = config('jwt-auth.token_expiration');
        $this->refreshExpiration = config('jwt-auth.refresh_expiration');
    }

    public function login(string $userId): array
    {
        $accessToken = $this->generateToken($userId, 'access_token', $this->tokenExpiration);

        $refreshToken = $this->generateToken($userId, 'refresh_token', $this->refreshExpiration);

        return compact('accessToken', 'refreshToken');
    }

    public function logout(string $token): bool
    {
        if(!$this->jwtAuthDriver){ // Driver is set on null
            return true;
        }

        $result = $this->jwtService->decode($token);
        $exp = $result->exp ?? (time() + $this->tokenExpiration);

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

    public function refresh(string $refreshToken): ?string
    {
        $result = $this->jwtService->decode($refreshToken);
        $data = $result?->data ?? null;
        if(!$data){
            return null;
        }

        return $this->generateToken($data->id, 'access_token', $this->tokenExpiration);
    }

    private function generateToken(string $userId, string $tokenType, int $expiration): string
    {
        return $this->jwtService->encode([
            'id' => $userId,
            'token_type' => $tokenType,
        ], $expiration);
    }

}
