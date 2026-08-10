<?php


namespace app\service\Logger;

class SyncSuccessLogger extends SyncLogger implements ILogger
{
    protected string $logFileName = 'success.txt';

    public function __construct()
    {
        parent::__construct();
        $this->setFile($this->logFileName);
    }
}