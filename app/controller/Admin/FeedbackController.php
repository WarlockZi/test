<?php

namespace app\controller\Admin;

use app\action\FeedbackAction;
use app\model\Feedback;
use JetBrains\PhpStorm\NoReturn;

class FeedbackController extends AdminscController
{
    public function __construct(
        public FeedbackAction $actions,
        public string         $model = Feedback::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }
}

