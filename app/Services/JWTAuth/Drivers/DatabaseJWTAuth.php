<?php

namespace App\Services\JWTAuth\Drivers;

use App\Interfaces\JWTAuthInterface;
use App\Repositories\JWTBlacklistRepository;
use DateTime;
use DateTimeZone;

readonly class DatabaseJWTAuth implements JWTAuthInterface
{
    public function __construct(private JWTBlacklistRepository $repository)
    {
    }

    public function logout(string $token, $exp): bool
    {
        $dateTime = (new DateTime('now', new DateTimeZone('Asia/Tehran')))
            ->setTimestamp($exp);

        return (bool) $this->repository->newItem([
            'token' => $token,
            'expires_at' => $dateTime->format('Y-m-d H:i:s'),
        ]);
    }

    public function authenticate(string $token): bool
    {
        if($this->repository->findByField('token', $token)){
            return false;
        }
        return true;
    }
}
