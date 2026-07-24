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
    }
}