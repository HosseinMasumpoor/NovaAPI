<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Core\Queue\QueueManger;

$appInstance = new App();

$queueManager = app()->make(QueueManger::class);

while(true){
    try {
        $job = $queueManager->pop();
        if($job){
            logMessage("running: " . get_class($job), 'info');
            $job->handle();
            logMessage("✅ done: " . get_class($job), 'success');
        }else{
            logMessage("No jobs in the queue. Waiting...", 'warning');
            sleep(5);
        }
    }catch (\Exception $e){
        logMessage("❌ Error while processing job: " . $e->getMessage(), 'error');
        sleep(5);
    }



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
