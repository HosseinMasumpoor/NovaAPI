<?php

namespace App\Core\Log;

class FileLog
{
    protected $logFile;
    protected string $filePath = __DIR__ . '/../../../storage/logs/laravel.log';

    public function __construct()
    {
        $this->logFile = fopen($this->filePath, "w") or die("Unable to open file!");
    }

    public function info($message): void
    {
        fwrite($this->logFile, date('Y-m-d H:i:s')." ".$message."\n");
    }
}
