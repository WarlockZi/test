<?php

namespace app\service\Sync\Load;

use Monolog\Logger;

class SyncLog
{
    public static function log($message): void
    {
        $logger = new Logger('sync-log');
        $logger->info($message);
        error_log($message);
    }

}