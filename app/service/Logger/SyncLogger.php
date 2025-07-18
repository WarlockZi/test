<?php


namespace app\service\Logger;


use app\service\FS;
use app\service\Storage\app\SyncStorage;
use app\service\Storage\StorageLog;

class SyncLogger implements ILogger
{
    protected string $logFile;

    public function __construct(
        private SyncStorage $storage,
    )
    {
        $this->logFile = FS::platformSlashes(APP_STORAGE . '/logs/sync.txt');

    }

    public function read(): string
    {
        return file_get_contents($this->storage->getPath());
    }


    public function write(string $content): bool
    {
        return file_put_contents($this->logFile, $content . PHP_EOL, FILE_APPEND);
    }

    public function setFile(string $fileName): ILogger
    {
        $this->logFile = StorageLog::getFile($fileName);
        return $this;
    }

    public function clear(): void
    {
        if ($this->logFile) file_put_contents($this->logFile, '');
    }

}