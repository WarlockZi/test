<?php

namespace app\controller;


use app\action\BrandAction;
use app\formRequest\SyncRequest;
use app\service\Logger\SyncLogger;
use app\service\Sync\SyncService;

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
        error_log('atest');
        error_log('before log');
        $this->logger->write('test start');
        error_log('after log');
        $this->service->requestFrom1s($req);
    }


}