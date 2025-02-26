<?php


try {
    define("ROOT", dirname(__FILE__));


    require_once ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

/// Составляем полное имя класса, добавив нэймспейс
//    $className = '\\MyProject\\Cli\\' . array_shift($argv);
//    if (!class_exists($className)) {
//        throw new \Exception('Class "' . $className . '" not found');
//    }

    $params = [];
    foreach ($argv as $argument) {
        preg_match('/^-(.+)=(.+)$/', $argument, $matches);
        if (!empty($matches)) {
            $paramName  = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    // Создаём экземпляр класса, передав параметры и вызываем метод execute()
//    $class = new $className($params);
//    $class->execute();
} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage();
}


function start(): void
{
    $config = new WSSC\Components\ServerConfig();
    $config->setClientsPerFork(2500);
    $config->setStreamSelectTimeout(2 * 3600);

    $webSocketServer = new WSSC\WebSocketServer(new app\Services\Chat_3\ServerHandler(), $config);
    $webSocketServer->run();
}






//<?php
//
//namespace app\Services\Chat_3;
//
//use WSSC\WebSocketServer;
//use WSSC\Components\ServerConfig;
//
//class Cli
//{
//    public function __construct()
//    {
//
//        $config = new ServerConfig();
//        $config->setClientsPerFork(2500);
//        $config->setStreamSelectTimeout(2 * 3600);
//
//        $webSocketServer = new WebSocketServer(new ServerHandler(), $config);
//        $webSocketServer->run();
//    }
//
//}