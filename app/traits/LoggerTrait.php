<?php

namespace app\traits;

use app\service\Logger\ILogger;
use app\service\Logger\SyncLogger;
use app\service\Response;
use JetBrains\PhpStorm\NoReturn;

trait LoggerTrait
{
    private ILogger $logger;
    protected function logDate(): void
    {
        $this->log(date("Y-m-d H:i:s"));
    }
    public function setLogger(ILogger $logger): void
    {
        $this->logger = $logger;
    }

    #[NoReturn] protected function logError(string $msg, $e): void
    {
        $this->logDate();
        $this->logger->write('- error -' . $msg . PHP_EOL . $e);
        if (DEV) {
            Response::exitWithPopup($msg);
        }
        exit();
    }

    protected function log(string $msg): void
    {
        $this->logger->write($msg);

    }
}