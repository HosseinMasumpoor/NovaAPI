<?php

namespace App\Core\Facades;

use App\Core\Facade;
use App\Core\Log\FileLog;

class LogFacade extends Facade
{

    protected static function getFacadeAccessor(): FileLog
    {
        return new FileLog();
    }
}
