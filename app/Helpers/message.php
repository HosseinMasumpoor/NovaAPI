<?php

if(!function_exists("trans")){
    function trans(string $key){
        $locale = $_ENV["APP_LOCALE"] ?? "en";

        $basePath = __DIR__ . "/../../lang/" . $locale;

        return getConfigByDotNotation($key, $basePath) ?? $key;
    }
}


