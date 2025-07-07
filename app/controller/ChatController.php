<?php

namespace app\controller;

use app\model\Chat;
use app\service\Response;

class ChatController extends AppController
{

    public function actionNewChat()
    {
        $req  = $this->ajax;
        $chat = Chat::with('messages')->firstOrCreate([
            'php_session' => $req['chatId']
        ], [
            'php_session' => $req['chatId']
        ]);
        response()->json(['user_name' => $chat->user_name, 'messages' => $chat->messages]);
    }

}