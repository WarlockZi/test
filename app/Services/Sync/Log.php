<?php

namespace app\Services\Sync;

use app\core\Response;

trait Log
{
    ///log
    protected function logReqest($func): void
    {
        $this->logDate();
        $this->logger->write("func {$func} started" . PHP_EOL);
    }

    protected function logDate(): void
    {
        $date = date("Y-m-d H:i:s");
        $this->logger->write($date);
    }

    protected function logError(string $msg, $e): void
    {
        $this->logDate();
        $this->logger->write('- error -' . $msg . PHP_EOL . $e);
        if (DEV) {
            Response::exitWithPopup($msg);
        }
        exit();
    }

    public function log(string $msg): void
    {
        $this->logDate();
        $this->logger->write($msg);
        if (DEV == '1') {
            Response::exitWithPopup($msg);
        }
    }
}