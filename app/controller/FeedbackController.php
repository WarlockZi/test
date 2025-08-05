<?php

namespace app\controller;

use app\model\Feedback;
use app\service\Router\IRequest;
use app\service\TelegramBot\TelegramBot;

class FeedbackController extends AppController
{
    public function __construct(
        public string $model = Feedback::class,
    )
    {
        parent::__construct();
    }

    public function actionUpdateOrCreate(IRequest $request): void
    {
        $tg  = new TelegramBot('question');
        $tg->send($this->formatMessage($request->body()['fields']));
        parent::actionUpdateOrCreate($request);
    }

    private function formatMessage(array $req): string
    {
        return implode("%0A", $req);// add new line
    }

    public function actionMessage(): void
    {
    }
}

