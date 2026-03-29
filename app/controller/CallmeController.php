<?php

namespace app\controller;

use app\formRequest\CallMeRequest;
use app\repository\CallmeRepository;
use app\service\TelegramBot\TelegramBot;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class CallmeController extends AppController
{
    #[NoReturn] public function actionIndex(CallMeRequest $request): void
    {
        $req = $request->validated();
        if (!CallmeRepository::firstOrCreate($req)) {
            response()->json(['error' => true, 'message' => 'Не обновлено']);
        }
        try {
            $TG = new TelegramBot('callme');
            $TG->send($req['phone']);
            response()->json(['success' => true]);
        } catch (Throwable $exception) {
            $exc = $exception;
            response()->json(['error' => true, 'message' => 'Не обновлено'.$exc->getMessage()]);
        }
    }
}