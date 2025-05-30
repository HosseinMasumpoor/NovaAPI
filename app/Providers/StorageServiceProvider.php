<?php

namespace App\Providers;

use App\Core\Auth\AuthManager;
use App\Core\Auth\DriverRegistry;
use App\Core\Provider\ServiceProvider;
use App\Core\Storage\Drivers\LocalStorageDriver;
use App\Core\Storage\Drivers\S3StorageDriver;
use App\Exceptions\JWTException;
use App\Guards\JWTGuard;
use App\Interfaces\JWTAuthInterface;
use App\Services\JWTAuth\Drivers\CacheJWTAuth;
use App\Services\JWTAuth\Drivers\DatabaseJWTAuth;
use App\Services\JWTAuth\JWTAuthService;

class StorageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerStorageDriver($this->app);
    }

    public function boot(): void
    {
        // TODO
    }

    private function registerStorageDriver($app): void
    {
        $registry = new \App\Core\Storage\DriverRegistry();

        $registry->extend('local', fn($config) => new LocalStorageDriver($config));
        $registry->extend('s3', fn($config) => new S3StorageDriver($config));

        $app->singleton(\App\Core\Storage\DriverRegistry::class, fn() => $registry);
    }
}
