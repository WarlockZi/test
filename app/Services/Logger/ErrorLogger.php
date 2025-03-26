<?php


namespace app\Services\Logger;


use app\core\FS;

class ErrorLogger implements ILogger
{
    protected string $logFile;

    public function __construct($fileName = 'errors/errors.txt')
    {
        $this->setFile($fileName);
    }

    public function read(): string
    {
        return file_get_contents($this->logFile);
    }

    public function write(string $content): bool
    {
        if (is_readable($this->logFile)) {
//        file_put_contents(time(), $content.PHP_EOL.PHP_EOL, FILE_APPEND);
        return file_put_contents($this->logFile, PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $content . PHP_EOL, FILE_APPEND);
        }
        return false;
    }

    public function setFile(string $fileName): ILogger
    {
        $this->logFile = FS::platformSlashes(ROOT . '/storage/logs/errors/' . $fileName);
        return $this;
    }

    public function clear(): void
    {
        if ($this->logFile) file_put_contents($this->logFile, '');
    }
}