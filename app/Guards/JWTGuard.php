<?php

namespace App\Guards;

use App\Core\Auth\Interfaces\AuthenticatableInterface;
use App\Core\Auth\Interfaces\GuardInterface;
use App\Services\JWTAuth\JWTAuthService;

class JWTGuard implements GuardInterface
{
    private ?AuthenticatableInterface $user = null;

    public function __construct(private readonly JWTAuthService $jwtAuthService, private string $model)
    {
    }

    public function check(): bool
    {
        return (bool) $this->user();
    }

    public function user(): ?array
    {
        if($this->user){
            return $this->user->toArray();
        }

        return $this->getUser()?->toArray();

    }

    private function getUser(): ?AuthenticatableInterface
    {
        $token = getAuthorizationToken();

        if(!$token){
            return null;
        }

        $userId = $this->jwtAuthService->checkAuth($token);

        if(!$userId){
            return null;
        }

        $this->user = (new $this->model())->find($userId);

        return $this->user;
    }

}
