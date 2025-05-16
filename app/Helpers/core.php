<?php

use JetBrains\PhpStorm\NoReturn;

if (!function_exists('basePath')) {
    function basePath(string $path = ''): string
    {
        return $GLOBALS['basePath'] . DIRECTORY_SEPARATOR . $path;
    }
}

if(!function_exists("getConfigByDotNotation")){
    function getConfigByDotNotation(string $key, string $basePath){
        $parts = explode('.', $key);
        $file = $basePath . DIRECTORY_SEPARATOR . $parts[0] . '.php';
        if(!file_exists($file)){
            return null;
        }

        unset($parts[0]);

        $fileContent = require $file;
        $value = $fileContent;
        foreach ($parts as $part){
            if(isset($value[$part])){
                $value = $value[$part];
            }
            else{
                return null;
            }
        }
        return $value;
    }
}

if(!function_exists("app")){
    function app(){
        return $GLOBALS['app'];
    }
}

if(!function_exists("config")){
    function config(string $key){
        $basePath = basePath("config");

        return getConfigByDotNotation($key, $basePath) ?? $key;
    }
}

if(!function_exists("dd")){
    #[NoReturn] function dd(...$args): void
    {
        var_dump(...$args);
        die();
    }
}


