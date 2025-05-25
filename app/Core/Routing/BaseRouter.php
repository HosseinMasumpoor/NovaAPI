<?php

namespace App\Core\Routing;

use App\Core\Routing\Interfaces\RouterInterface;

abstract class BaseRouter implements RouterInterface
{
    public function __construct(protected Router $router){}

    abstract public function register(): void;
}
