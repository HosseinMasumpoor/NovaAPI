<?php

namespace App\Providers;

use App\Core\Auth\AuthManager;
use App\Core\Auth\DriverRegistry;
use App\Core\Provider\ServiceProvider;
use App\Exceptions\JWTException;
use App\Guards\JWTGuard;
use App\Interfaces\JWTAuthInterface;
use App\Services\JWTAuth\Drivers\CacheJWTAuth;
use App\Services\JWTAuth\Drivers\DatabaseJWTAuth;
use App\Services\JWTAuth\JWTAuthService;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $app = $this->app;
        $this->registerJWTAuthDriver($app);
        $this->registerAuthDriver($app);
    }

    public function boot(): void
    {
        // TODO
    }

    private function registerJWTAuthDriver($app): void
    {
        $app->bind(JWTAuthInterface::class, function () use ($app) {
            return match (config('jwt-auth.logout_driver')) {
                'database' => $app->resolve(DatabaseJWTAuth::class),
                'cache' => $app->resolve(CacheJWTAuth::class),
                'null' => null,
                default => throw new JWTException('Invalid JWT driver!'),
            };
        });
    }

    private function registerAuthDriver($app): void
    {
        $app->singleton(DriverRegistry::class, function () use ($app) {
            $registry = new DriverRegistry();
            $registry->extend('jwt', function($config, $model) use ($app) {
                return new JWTGuard($app->make(JWTAuthService::class), $model);
            });
            return $registry;
        });
    }
}
