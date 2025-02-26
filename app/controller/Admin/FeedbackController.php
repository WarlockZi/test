<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Feedback;
use app\view\Feedback\FeedbackView;

class FeedbackController extends AppController
{
    public function __construct(
        public string $model = Feedback::class,
        public FeedbackView $feedbackView = new FeedbackView()
    )
    {
        parent::__construct();
    }


    public function actionIndex(): void
    {
        $content = $this->feedbackView->all();
        $this->setVars(compact('content'));
    }
}

