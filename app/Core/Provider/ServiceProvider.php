<?php

namespace App\Core\Provider;

use App\Core\Container;

abstract class ServiceProvider
{
    protected Container $app;

    public function __construct(Container $app){
        $this->app = $app;
    }

    abstract public function register();
    abstract public function boot();
}

