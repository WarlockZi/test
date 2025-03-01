<?php

function start(): void
{
    $config = new WSSC\Components\ServerConfig();
    $config->setClientsPerFork(2500);
    $config->setStreamSelectTimeout(2 * 3600);

    $webSocketServer = new WSSC\WebSocketServer(new app\Services\Chat_3\ServerHandler(), $config);
    $webSocketServer->run();
}