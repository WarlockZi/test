<?php

namespace app\controller;


use app\formRequest\SyncRequest;
use app\service\Logger\SyncLogger;
use app\service\Sync\Load\LoadService;
use app\service\Sync\SyncActions;
use app\service\Sync\SyncService;
use Throwable;

class AtestController extends AppController
{
    public function __construct(
    )
    {
        parent::__construct();
    }


    public function actionIndex(): void
    {
        try {
            error_log('atest start');
//            $this->logger->write('test start');
//            error_log('after log');
//            $services = new SyncService(new LoadService(), new SyncLogger(), new SyncActions(new SyncLogger()));
//            $logger = new SyncLogger();
            error_log('atest new serv ');
//            $services->requestFrom1s();
        } catch (Throwable $exception) {
            error_log('atest'.$exception);
        }
    }
}