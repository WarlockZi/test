<?php

namespace app\controller;

use app\core\Response;
use app\model\Chat;

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
        Response::json(['user_name' =>$chat->user_name,'messages'=>$chat->messages]);
    }

}