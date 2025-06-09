<?php

namespace App\Providers;

use App\Core\Provider\ServiceProvider;
use App\Core\Validation\DriverRegistry;
use App\Core\Validation\Drivers\IlluminateValidatorDriver;
use App\Core\Validation\Drivers\RakitValidatorDriver;
use App\Core\Validation\Drivers\RespectValidatorDriver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DriverRegistry::class, function(){
            return new DriverRegistry();
        });
        $validatorRegistry = $this->app->make(DriverRegistry::class);
        $validatorRegistry->extend('rakit', function($config){
            return new RakitValidatorDriver($config);
        });

        $validatorRegistry->extend('illuminate', function($config){
            return new IlluminateValidatorDriver($config);
        });

        $validatorRegistry->extend('respect', function($config){
            return new RespectValidatorDriver($config);
        });
    }

    public function boot()
    {
        // TODO: Implement boot() method.
    }
}
