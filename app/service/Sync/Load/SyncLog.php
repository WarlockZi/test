<?php

namespace app\service\Sync\Load;

class SyncLog
{
    public static function log($message): void
    {
        error_log($message);
    }

}