<?php

namespace App\Core\Facades;

use App\Core\Cache\Cache;
use App\Core\Facade;

class CacheFacade extends Facade
{
    public static function getFacadeAccessor(): Cache
    {
        return new Cache();
    }
}
