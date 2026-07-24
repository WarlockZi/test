<?php

namespace app\controller;


use app\action\BrandAction;

class AtestController extends AppController
{
    public function __construct(
    )
    {
        parent::__construct();
    }


    public function actionIndex(): void
    {

        error_log('atest');
        response()->consoleLog('dd');
    }


}