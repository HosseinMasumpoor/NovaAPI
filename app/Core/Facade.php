<?php

namespace App\Core;

abstract class Facade
{
    protected static $instance;

    protected static function getInstance(){
        static::$instance = static::getFacadeAccessor();
        return static::$instance;
    }

    abstract protected static function getFacadeAccessor();

    public static function __callStatic($method, $args){
        return static::getInstance()->$method(...$args);
    }
}
