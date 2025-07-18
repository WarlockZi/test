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
        return file_get_contents($this->errorLog);
    }

    public function write(string $content): bool
    {
        if (is_readable($this->errorLog)) {
            return file_put_contents($this->errorLog, PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $content . PHP_EOL, FILE_APPEND);
        }
        return false;
    }

    private function setLogsPathOwner(): void
    {
        $logsPath = $this->logsPath;
        $dir      = FS::platformSlashes(ROOT . $logsPath);
        $user = 'vitexopt';

        if (!is_dir($dir)) {
            die("File does not exist");
        }

        if (!posix_getpwuid(fileowner($dir))) {
            die("Cannot get current file owner");
        }

        if (!posix_getpwnam($user)) {
            die("User $user does not exist");
        }

        if (!chown($dir, $user)) {
            // Get last error
            $error = error_get_last();
            die("chown failed: " . $error['message']);
        }


        $res = chown($dir, $user);
        if (!exec(
            "chown -R {$user}:{$user} ". escapeshellarg($dir),
            $output,
            $retval
        )) {
            throw new \Exception("Unable to set logs path owner");
        }
    }

    public function setFile(string $fileName): ILogger
    {
        $path = '/storage/logs/errors';
        $dir  = FS::platformSlashes(ROOT . $path);

        if (!is_dir($dir)) {
            $this->setLogsPathOwner();
            $parentPath = $dir;

            $path = FS::getOrCreateAbsolutePath($path);
//            if (!mkdir($dir, 0755, true)) {
//                error_log("Failed to create log directory: $dir");
//                // Fallback to a different directory if possible
//                $dir = sys_get_temp_dir();
//            }
        }


        $fileName = $dir . DIRECTORY_SEPARATOR . $fileName;
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