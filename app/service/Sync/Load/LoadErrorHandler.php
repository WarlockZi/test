<?php

namespace app\service\Sync\Load;

use app\service\Logger\SyncLogger;
use JetBrains\PhpStorm\NoReturn;

class LoadErrorHandler
{
    /**
     * @throws \Exception
     */
    #[NoReturn] public static function handleError($errno, $errstr, $errfile, $errline): void
    {
        $errstring = "exception - $errstr, file - $errfile, line - $errline";
        $logger = new SyncLogger();
        $logger->write($errstring);
    }
    #[NoReturn] public static function handleException($errno, $errstr, $errfile, $errline): void
    {
        $errstring = "error - $errstr, file - $errfile, line - $errline";
        $logger = new SyncLogger();
        $logger->write($errstring);
    }
}