<?php

namespace app\controller;


use app\formRequest\SyncRequest;
use app\service\Logger\SyncLogger;
use app\service\Sync\SyncService;
use Throwable;

class AtestController extends AppController
{
    public function __construct(
        private SyncLogger  $logger,
        private SyncService $service,
    )
    {
        parent::__construct();
    }


    public function actionIndex(SyncRequest $req): void
    {
        try {
            error_log('atest');
            $this->logger->write('test start');
            error_log('after log');
            $this->service->requestFrom1s($req);
        } catch (Throwable $exception) {
            error_log('atest'.$exception);
        }
    }
}