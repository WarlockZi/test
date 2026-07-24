<?php

namespace app\controller;


class AtestController extends AppController
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
            error_log('atest start');
//            $services = new SyncService(new LoadService(), new SyncLogger(), new SyncActions(new SyncLogger()));
//            $logger = new SyncLogger();
            error_log('atest new serv ');
//            $services->requestFrom1s();
    }
}