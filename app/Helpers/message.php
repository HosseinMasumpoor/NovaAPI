<?php

if(!function_exists("trans")){
    function trans(string $key){
        $locale = $_ENV["APP_LOCALE"] ?? "en";

        $basePath = basePath("lang") . DIRECTORY_SEPARATOR . $locale;

        return getConfigByDotNotation($key, $basePath) ?? $key;
    }
}


