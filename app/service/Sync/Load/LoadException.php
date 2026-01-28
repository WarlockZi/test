<?php

namespace app\service\Sync\Load;

use app\exception\LoggableException;
use app\service\Fs\FS;

class LoadException extends LoggableException
{
    protected function setLogFile(): void
    {
        $this->logFile = FS::resolve(ROOT, '/storage/logs/sync/log.txt');
    }
}