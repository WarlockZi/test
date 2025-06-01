<?php

namespace app\controller;

use app\repository\CallmeRepository;
use app\service\Response;
use app\service\TelegramBot\TelegramBot;

class CallmeController extends AppController
{

    public function actionIndex(): void
    {
        $req = $this->ajax;
        if (CallmeRepository::firstOrCreate($req)) {
            $TG = new TelegramBot('callme');
            $TG->send($req['phone']);
            response()->json(['success' => true]);
        }
        response()->json(['error' => true]);
    }

}