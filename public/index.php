<?php

use app\core\Router;
session_unset();
session_start();
$_SESSION['phpSession'] = session_id();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

try {
//    \app\Services\MockUserService::mockUser();
//    \app\Services\UrlService::generateUrls();
//    new \app\Services\XLService\XLService();
//    \app\Services\SiteMapService::generateMap();

//    $cli =  new \app\Services\Chat_3\Cli();
//    $handler = new \app\Services\Chat_3\ServerHandler();
//    $client = new \app\Services\Chat_3\Client();

    $router = new Router($_SERVER['REQUEST_URI'] ?? '');
    $router->dispatch();
    exit();
} catch (Throwable $e) {
    if (!DEV) {
        $logger = new \app\Services\Logger\ErrorLogger();
        $logger->write($e);
    }
    exit($e);
}