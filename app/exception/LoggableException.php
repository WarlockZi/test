<?php

namespace app\exception;

use app\service\Fs\FS;
use Exception;

class LoggableException extends Exception
{
    protected $logFile;
    public function log(): void
    {
        $logMessage = sprintf(
            "[%s] %s in %s:%d\nStack trace:\n%s",
            date('Y-m-d H:i:s'),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine(),
            $this->getTraceAsString()
        );
        $this->setLogFile();

        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
    protected function setLogFile(): void{
        $this->logFile =FS::resolve(ROOT, '/sync/logs/error.log');
    }

}