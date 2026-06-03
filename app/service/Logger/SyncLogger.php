<?php


namespace app\service\Logger;


use app\service\Fs\FS;
use Exception;

class SyncLogger implements ILogger
{
    protected string $logPath;
    protected string $logDir = '/sync';
    protected string $logName = 'log.txt';

    public function __construct()
    {
        $this->setFile($this->logName);
    }

    public function setFile(string $fileName): ILogger
    {
        $dir = $this->setPath();

        $fullPath = $dir . $this->logName;
        if (!is_readable($fullPath)) {
            touch($fullPath);
        }
        $this->logPath = $fullPath;
        return $this;
    }

    private function setPath(): string
    {
        $dir = FS::resolve(LOG_STORAGE, $this->logDir);
        if (!is_dir($dir)) {
            mkdir($dir, 0766, true);
        }
        return $dir;
    }

    /**
     * @throws Exception
     */
    public function read(): string
    {
        if (!is_readable($this->logPath)) {
            throw new Exception('Log file not readable');
        }
        return file_get_contents($this->logPath);
    }

    /**
     * @throws Exception
     */
    public function write(string $content): bool
    {
        if (!is_writable($this->logPath)) {
            throw new Exception('Log file not writable');
        }

        return file_put_contents($this->logPath,
            PHP_EOL . date('Y-m-d H:i:s') .' - '. $content , FILE_APPEND
        );
    }

    public function clear(): void
    {
        if ($this->logPath) file_put_contents($this->logPath, '');
    }

}