<?php

namespace App\Core\Log;

class FileLog
{
    protected $logFile;
    protected string $filePath;

    public function __construct()
    {
        $this->filePath = basePath("storage/core/logs/laravel.log");
        $this->logFile = fopen($this->filePath, "w") or die("Unable to open file!");
    }

    public function info($message): void
    {
        fwrite($this->logFile, date('Y-m-d H:i:s')." ".$message."\n");
    }
}
