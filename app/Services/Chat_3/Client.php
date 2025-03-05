<?php

namespace app\Services\Chat_3;

use WSSC\Components\ClientConfig;
use WSSC\WebSocketClient;

class Client
{
    public function __construct()
    {
        $config = new ClientConfig();
        $config->setFragmentSize(8096);
        $config->setTimeout(15);
        $config->setHeaders([
            'X-Custom-Header' => 'Foo Bar Baz',
        ]);

// if proxy settings is of need
        $config->setProxy('vi-prod', '8000');
//        $config->setProxyAuth('proxyUser', 'proxyPass');

        $client = new WebSocketClient('ws://localhost:8000/notifications/messanger/yourtoken123', new ClientConfig());
        $client->send('{"user_id" : 123}');
        echo $client->receive();
    }
}