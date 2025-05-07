<?php

namespace App\Services;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    const string DEFAULT_KEY = 'example_key';
    const string DEFAULT_ALGO = 'HS256';
    const int DEFAULT_EXPIRATION_TIME = 3600;

    public function encode(array $data, int $expirationTime = self::DEFAULT_EXPIRATION_TIME, string $key = self::DEFAULT_KEY, string $algo = self::DEFAULT_ALGO): string{
        $payload = [
            'iss' => $_ENV["APP_URL"],
            'aud' => $_ENV["APP_URL"],
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + $expirationTime,
            'data' => $data
        ];

        return JWT::encode($payload, $key, $algo);
    }

    public function decode(string $token, string $key = self::DEFAULT_KEY, string $algo = self::DEFAULT_ALGO): \stdClass
    {
        return JWT::decode($token, new Key($key, $algo));
    }
}
