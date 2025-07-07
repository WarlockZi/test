<?php


namespace app\service\Logger;


use app\service\FS;

class ErrorLogger implements ILogger
{
    protected string $errorLog;

    public function __construct(string $fileName)
    {
        $this->setFile($fileName);
    }

    public function read(): string
    {
        return file_get_contents($this->errorLog);
    }

    public function write(string $content): bool
    {
        if (is_readable($this->errorLog)) {
        return file_put_contents($this->errorLog, PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $content . PHP_EOL, FILE_APPEND);
        }
        return false;
    }

    public function setFile(string $fileName): ILogger
    {
        $this->errorLog = FS::platformSlashes(ROOT . '/storage/logs/errors/' . $fileName);
        return $this;
    }

    public function clear(): void
    {
        if ($this->errorLog) file_put_contents($this->errorLog, '');
    }
}