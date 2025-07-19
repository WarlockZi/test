<?php


namespace app\service\Logger;


use app\service\Fs\FS;

class ErrorLogger implements ILogger
{
    protected string $errorLog;
    private string $logsPath = '/storage/logs';

    public function __construct(string $fileName = 'error.txt')
    {
        $this->setFile($fileName);
    }

    public function read(): string
    {
        if (!is_readable($this->errorLog)) {
            throw new \Exception('Log file not readable');
        }
        return file_get_contents($this->errorLog);
    }

    public function write(string $content): bool
    {
        if (is_writable($this->errorLog)) {
            return file_put_contents($this->errorLog, PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $content . PHP_EOL, FILE_APPEND);
        }
        return false;
    }

    private function setPath(): string
    {
        $dir = FS::resolve(LOG_STORAGE, '/errors');
        if (!is_dir($dir)) {
            mkdir($dir, 0766, true);
        }
        return $dir;
    }

    public function setFile(string $fileName): ILogger
    {
        $dir = $this->setPath();

        $fullPath = $dir . $fileName;
        if (!is_readable($fullPath)) {
            touch($fullPath);
        }
        $this->errorLog = $fullPath;
        return $this;
    }

    public function clear(): void
    {
        if ($this->errorLog) file_put_contents($this->errorLog, '');
    }
}