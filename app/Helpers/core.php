<?php

use App\Core\Auth\AuthManager;
use App\Core\Auth\Interfaces\GuardInterface;
use App\Core\Facades\ConfigFacade;
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
    function config(string $key): array|string
    {
        return ConfigFacade::get($key);
    }
}

if(!function_exists("request")){
    function request()
    {
        return $GLOBALS['request'];
    }
}

if(!function_exists("dd")){
    #[NoReturn] function dd(...$args): void
    {
        var_dump(...$args);
        die();
    }
}

if(!function_exists("auth")){
    function auth(string $guard = null): GuardInterface
    {
        return app()->make(AuthManager::class)->guard($guard);
    }
}

if(!function_exists("getAuthorizationToken")){
    function getAuthorizationToken(): ?string
    {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        if (!$authorizationHeader && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $authorizationHeader = $headers['Authorization'];
            } elseif (isset($headers['authorization'])) {
                $authorizationHeader = $headers['authorization'];
            }
        }

        if (!$authorizationHeader && function_exists('getallheaders')) {
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                $authorizationHeader = $headers['Authorization'];
            } elseif (isset($headers['authorization'])) {
                $authorizationHeader = $headers['authorization'];
            }
        }

        if ($authorizationHeader && preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

if(!function_exists("toDateTime")){
    function getDateTime(int $time = 0): ?DateTime
    {
        $timestamp = time() + $time;
        return (new \DateTime())->setTimestamp($timestamp);
    }
}

if (!function_exists('env')) {
    function env(string $name): mixed
    {
        return $_ENV[$name] ?? null;
    }
}


