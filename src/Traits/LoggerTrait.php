<?php

namespace App\Traits;

trait LoggerTrait
{
    private $logFilePath = __DIR__ . '/../../logs/app.log';

    public function log($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] - $message" . PHP_EOL;
        file_put_contents($this->logFilePath, $logMessage, FILE_APPEND);
    }
} 