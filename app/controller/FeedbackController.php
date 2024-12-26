<?php

namespace app\controller;

use app\model\Feedback;

class FeedbackController extends AppController
{
    public function __construct(
        public string $model = Feedback::class,
    )
    {
        parent::__construct();
    }


    public function actionMessage(): void
    {
    }
}

