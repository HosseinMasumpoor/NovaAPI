<?php

namespace App\Core\Config;

use App\Core\Facades\CacheFacade;

class ConfigManager
{
    private string $cacheKey = 'app_config';
    private array $runtimeConfig = [];

    public function get(string $key): string|array
    {
        $parts = explode('.', $key);

        $runtimeConfig = $this->getConfigByParts($this->runtimeConfig, $parts);
        if($runtimeConfig) {
            return $runtimeConfig;
        }

        if ($parts[0] === 'cache') {
            return $this->getFileConfig($parts) ?? $key;
        }

        if(CacheFacade::has($this->cacheKey)) {
            $config =  $this->getCachedConfig($parts);
        }else{
            $config = $this->getFileConfig($parts);
        }

        return $config ?? $key;
    }

    public function set(string $key, string|array $value): void
    {
        $this->runtimeConfig[$key] = $value;
    }

    public function cache(): bool
    {
        $config = [];
        $configDir = basePath('config');
        foreach(glob($configDir . '/*.php') as $file){
            $key = strtolower(basename($file, '.php'));
            $config[$key] = require $file;
        }

        return (bool) CacheFacade::put($this->cacheKey, serialize($config));

    }

    public function clearCache(): bool
    {
        return CacheFacade::forget($this->cacheKey);
    }

    private function getCachedConfig(array $parts): string|array|null
    {
        $config = CacheFacade::get($this->cacheKey);

        $config = is_string($config) ? unserialize($config) : $config;

        return $this->getConfigByParts($config, $parts);
    }

    private function getFileConfig(array $parts): string|array|null{
        $basePath = basePath("config");

        $file = $basePath . DIRECTORY_SEPARATOR . $parts[0] . '.php';

        if(!file_exists($file)){
            return null;
        }

        unset($parts[0]);
        $fileContent = require $file;
        $value = $fileContent;

        return $this->getConfigByParts($value, $parts);
    }

    private function getConfigByParts(array $config, array $parts): string|array|null
    {
        foreach ($parts as $part){
            if(is_array($config) && isset($config[$part])){
                $config = $config[$part];
            }
            else{
                return null;
            }
        }
        return $config;
    }
}
