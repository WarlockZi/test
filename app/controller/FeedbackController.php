<?php

namespace app\controller;

use app\model\Feedback;
use app\Services\TelegramBot\TelegramBot;

class FeedbackController extends AppController
{
    public function __construct(
        public string $model = Feedback::class,
    )
    {
        parent::__construct();
    }
    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;
        $tg = new TelegramBot();
        $tg->send($this->formatMessage($req['fields']));
        parent::actionUpdateOrCreate();
    }

    private function formatMessage(array $req): string
    {
        return implode("%0A", $req);// add new line
    }

    public function actionMessage(): void
    {
    }
}

