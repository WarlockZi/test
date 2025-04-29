<?php

namespace app\service\Chat;

class ChatService
{
    public function __construct(
//        private string $adress = "tcp://0.0.0.0:8001",
    )
    {
//        new Chat_2();
    }

    public static function startServer()
    {
        $config = array(
//        'host' => '0.0.0.0',
            'host' => 'vi-prod',
            'port' => 8000,
            'workers' => 1,
        );

        $WebsocketServer = new WebsocketServer($config);
        $WebsocketServer->start();

    }

}