<?php


namespace app\service\Logger;


use app\service\Fs\FS;

class ErrorLogger implements ILogger
{
    protected string $errorLog;

    public function __construct(string $fileName='error.txt')
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
        $path = '/storage/logs/errors';
        $dir = FS::platformSlashes(ROOT . $path);

        if (!is_dir($dir)) {

            $path = FS::getOrCreateAbsolutePath($path);
//            if (!mkdir($dir, 0755, true)) {
//                error_log("Failed to create log directory: $dir");
//                // Fallback to a different directory if possible
//                $dir = sys_get_temp_dir();
//            }
        }

        $fileName = $dir . DIRECTORY_SEPARATOR.$fileName;
        if (!is_readable($fileName)) {
            touch($fileName);
        }
        $this->errorLog = $fileName;
        return $this;
    }

    public function clear(): void
    {
        if ($this->errorLog) file_put_contents($this->errorLog, '');
    }
}