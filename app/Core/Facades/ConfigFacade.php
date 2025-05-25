<?php

namespace App\Core\Facades;

use App\Core\Cache\Cache;
use App\Core\Config\ConfigManager;
use App\Core\Facade;

class ConfigFacade extends Facade
{
    public static function getFacadeAccessor(): ConfigManager
    {
        return new ConfigManager();
    }
}
