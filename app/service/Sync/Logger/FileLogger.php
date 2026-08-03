<?php

namespace app\service\Sync\Logger;


class FileLogger implements ILogger
{
    private string $logFile;

    public function __construct(string $logFile = '/var/log/app.log')
    {
        $this->logFile = $logFile;
    }

    public function log(string $message): void
    {
        $this->write("[LOG] " . date('Y-m-d H:i:s') . " - " . $message);
    }

    public function error(string $message): void
    {
        $this->write("[ERROR] " . date('Y-m-d H:i:s') . " - " . $message);
    }

    public function info(string $message): void
    {
        $this->write("[INFO] " . date('Y-m-d H:i:s') . " - " . $message);
    }

    private function write(string $message): void
    {
        file_put_contents($this->logFile, $message . PHP_EOL, FILE_APPEND);
    }
}
