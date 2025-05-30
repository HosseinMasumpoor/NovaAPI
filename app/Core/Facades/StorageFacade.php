<?php

namespace App\Core\Facades;

use App\Core\Facade;
use App\Core\Storage\Storage;

class StorageFacade extends Facade
{

    protected static function getFacadeAccessor(): Storage
    {
        return app()->make(Storage::class);
    }
}
