<?php


namespace app\service\Logger;


use app\service\Fs\FS;

class SyncLogger implements ILogger
{
    protected string $syncLog;
    private string $logsPath = '/storage/logs';

    public function __construct(
    )
    {
        $this->setFile('import.txt');
    }
    public function setFile(string $fileName): ILogger
    {
        $dir = $this->setPath();

        $fullPath = $dir . $fileName;
        if (!is_readable($fullPath)) {
            touch($fullPath);
        }
        $this->syncLog = $fullPath;
        return $this;
    }

    private function setPath(): string
    {
        $dir = FS::resolve(LOG_STORAGE, '/sync');
        if (!is_dir($dir)) {
            mkdir($dir, 0766, true);
        }
        return $dir;
    }

    public function read(): string
    {
        if (!is_readable($this->syncLog)) {
            throw new \Exception('Log file not readable');
        }
        return file_get_contents($this->syncLog);
    }

    public function write(string $content): bool
    {
        if (is_writable($this->syncLog)) {
            return file_put_contents($this->syncLog,
                PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') .
                PHP_EOL . $content . PHP_EOL, FILE_APPEND
            );
        }
        return false;
    }




    public function clear(): void
    {
        if ($this->logFile) file_put_contents($this->logFile, '');
    }

}