<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Core\Config\ConfigManager;

$appInstance = new App();

$configManager = new ConfigManager();
if($configManager->cache()){
    logMessage("config cached successfully", 'success');
}
else{
    logMessage("config failed to cache", 'error');
}

function logMessage(string $message, string $type = 'info'): void
{
    $timestamp = date('Y-m-d H:i:s');

    $color = match ($type) {
        'success' => "\033[32m",
        'error' => "\033[31m",
        'warning' => "\033[33m",
        default => "\033[36m",
    };

    echo "{$color}[{$timestamp}] {$message}\033[0m" . PHP_EOL;
}
