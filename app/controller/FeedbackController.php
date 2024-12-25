<?php

namespace app\controller;

class FeedbackController extends AppController
{
    public function __construct(
    )
    {
        parent::__construct();
    }


    public function actionMessage(): void
    {
        $req = $this->ajax;

    }
}

