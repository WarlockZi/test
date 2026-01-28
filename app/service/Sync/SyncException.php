<?php

namespace app\service\Sync;

class SyncException extends \Exception
{
    public function errorWithLog(string $message): string
    {
        error_log(sprintf(
                __CLASS__ . ": %s\n",
                $message
            ));
        return $message;
    }
}